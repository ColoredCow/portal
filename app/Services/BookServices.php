<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Vision\Feature;
use Vision\Request\Image\LocalImage;
use Vision\Vision;

class BookServices
{
    public function __construct()
    {
    }

    public static function getBookInfo($file, $onlyISBN = false)
    {
        $description = self::getISBN($file);

        if (strlen($description) < 13) {
            return 'try again with another image current isbn is invalid :' . $description;
        }

        if (!$description) {
            return 'invalid image please try again';
        }

        return ($onlyISBN) ? $description : self::getBookDetails($description);
    }

    public static function getBookDetails($isbn)
    {
        
        $client = new Client();
        $res = $client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn);
        $book = json_decode($res->getBody(), true);

        /**
         * There is a bug in google books API.
         * 
         */
        if (!isset($book['items'])) {
            $res = $client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q=ISBN:' . $isbn);
            $book = json_decode($res->getBody(), true);
            return 'please try again';
        }

        if (!isset($book['items'])) {
            return 'please try again';
        }

        return $book;
    }


    public static function getISBN($file) {
        ini_set('max_execution_time', 3600);
        $apiKey = env('GOOGLE_VISION_API_KEY', 'AIzaSyCM1QEosQzkoe8-HFBFN9xBOfPPCZBEfEk');
        $vision = new Vision( $apiKey, [new Feature(Feature::TEXT_DETECTION, 100)]);
        $imagePath = $file->path();
        $response = $vision->request(new LocalImage($imagePath));
        $faces = $response->getTextAnnotations();
        $description = '';
        $lastOne = '';
        $data = [];
        $i = 0;

        foreach ($faces as $face) {
            $data[$i] = $face->getDescription();
            $i++;
            if ('isbn' === strtolower($lastOne) || 'sbn' === strtolower($lastOne)) {
                $description = $face->getDescription();
            }
            $lastOne = $face->getDescription();
        }

        $description = str_replace('-', '', trim($description));

        return $description;
    }
}
