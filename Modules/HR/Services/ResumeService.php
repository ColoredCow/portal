<?php

namespace Modules\HR\Services;

use Spatie\PdfToText\Pdf;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ResumeService
{
   
    public static function getTextFromPDF($url, $type, $values = [])
    {
        $resumeAsText = self::getResumeAsTextFromUrl($url);
        return self::parseText(self::buildQuery($resumeAsText, $values, $type));

    }

    public static function parseText($questionText)
    {  
        if(!config('services.open_ai.active')) {
            return "OpenAI Service is not active.";
        }
        
        $data = Arr::add(config('services.open_ai.default_params'), 'prompt', $questionText);
        return  Http::withToken(config('services.open_ai.api_key'))
        ->post('https://api.openai.com/v1/completions', $data)
        ->json() ;
    }

    public static function downloadTheFile($url) {
        $filePath = Str::random(10) . 'resume.pdf';
        Storage::disk('local')->put($filePath, file_get_contents($url));
        return Storage::disk('local')->path($filePath);
    }

    public static function buildQuery($resumeAsText, $values, $type) {
        $separator = '<|endoftext|>';
        $prefix = "Summarized";

        if($type == 'value_summery') {
            $valuesAsString = self::buildValuesAsString($values);
            // $prefix = "Summarized the evaluation based on these ColoredCow values {$valuesAsString}";
            $prefix = "Does this resume reflects these values, if yes can you explain how?, values: {$valuesAsString}";
        }

        return "{$prefix} this resume {$separator} resume: {$resumeAsText} ";
    }


    public static function buildValuesAsString($data) {
        $result = "\n";
        foreach($data as $key => $value) {
            $index = $key + 1;
            $result .= "{$index}. {$value} \n";
        }

        return $result;
    }

    public static function getResumeAsTextFromUrl($url) {
        $filePath = self::downloadTheFile($url);

        $resumeAsText =  (new Pdf(config('services.pdf_to_text.lib_path')))
        ->setPdf($filePath)
        ->text();

        Storage::disk('local')->delete(basename($filePath));

        return $resumeAsText;
    }
}
