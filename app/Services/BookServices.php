<?php

namespace App\Services;

use File;
use GuzzleHttp\Client;
use Vision\Feature;
use Vision\Request\Image\LocalImage;
use Vision\Vision;

class BookServices
{
    /**
     * Fetch book details from $isbn.
     * @param string $isbn
     * @return mixed
     */
    public static function getBookDetails($isbn)
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn, [
            'timeout' => 5.0,
        ]);
        $book = json_decode($res->getBody(), true);

        if (! isset($book['items'])) {
            $res = $client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q=ISBN:' . $isbn, [
                'timeout' => 5.0,
            ]);

            $book = json_decode($res->getBody(), true);
        }

        if (! isset($book['items'])) {
            return 'please try again';
        }

        return $book;
    }

    /**
     * Fetch ISBN form book image.
     *
     * @param File $file
     * @return string
     */
    public static function getISBN($file)
    {
        $apiKey = config('constants.google.vision-api-key');
        $vision = new Vision($apiKey, [new Feature(Feature::TEXT_DETECTION, 100)]);
        $response = $vision->request(new LocalImage($file->path()));
        $faces = $response->getTextAnnotations();
        $description = '';
        $currentText = '';

        foreach ($faces as $face) {
            $faceDescription = $face->getDescription();
            if ('isbn' === strtolower($currentText) || 'sbn' === strtolower($currentText)) {
                $description = $faceDescription;
            }
            $currentText = $faceDescription;
        }

        $description = str_replace('-', '', trim($description));

        return $description;
    }
}
