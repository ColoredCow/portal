<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class FileHelper
{
    /**
     * Retrieve file path based upon year and month.
     *
     * @param string $year  year directory of the file
     * @param string $month month directory of the file
     * @param string $file  invoice file name
     */
    public static function getFilePath($year, $month, $file)
    {
        $filePath = $year . '/' . $month . '/' . $file;

        if (! Storage::exists($filePath)) {
            return false;
        }

        return $filePath;
    }

    /**
     * Retrieve storage directory based upon current year and month.
     *
     * @return string
     */
    public static function getCurrentStorageDirectory()
    {
        $now = now();

        return $now->format('Y') . '/' . $now->format('m');
    }

    public static function getOfferLetterFileName(Applicant $applicant)
    {
        $dashedApplicantName = str_replace(' ', '-', $applicant->name);
        $timestamp = now()->format('Ymd');

        return "{$dashedApplicantName}-{$timestamp}.pdf";
    }

    public static function generateOfferLetter(Application $application, $offerLetterPreview = false)
    {
        $offer_letter_body = Setting::getOfferLetterTemplate()['body'];
        $job = $application->job;
        $applicant = $application->applicant;
        $pdf = Pdf::loadView('hr.application.draft-joining-letter', compact('applicant', 'job', 'offer_letter_body'));
        $fileName = self::getOfferLetterFileName($applicant, $pdf);
        if ($offerLetterPreview) {
            return $pdf->stream($fileName);
        }
        $directory = 'app/public/' . config('constants.hr.offer-letters-dir');
        $fullPath = storage_path($directory . '/' . $fileName);
        $pdf->save($fullPath);
        $filePath = config('constants.hr.offer-letters-dir') . '/' . $fileName;
        $application->update([
            'offer_letter' => $filePath,
        ]);

        return $application->offer_letter;
    }
}
