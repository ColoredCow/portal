<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class BookServices
{
    /**
     * Fetch book details from $isbn.
     *
     * @param string $isbn
     *
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
     * @param mixed $file
     *
     * @return string
     */
    public static function getISBN($file)
    {
        $apiKey = config('constants.google.vision-api-key');

        $response = Http::timeout(5)->post('https://vision.googleapis.com/v1/images:annotate?key=' . $apiKey, [
            'requests' => [[
                'image' => ['content' => base64_encode(file_get_contents($file->path()))],
                'features' => [['type' => 'TEXT_DETECTION', 'maxResults' => 100]],
            ]],
        ]);

        if ($response->failed()) {
            \Log::warning('Google Vision API error', ['status' => $response->status(), 'body' => $response->body()]);

            return '';
        }

        $annotations = $response->json('responses.0.textAnnotations') ?? [];
        $description = '';
        $currentText = '';

        foreach ($annotations as $annotation) {
            $text = $annotation['description'] ?? '';
            if (in_array(strtolower($currentText), ['isbn', 'sbn'])) {
                $description = $text;
            }
            $currentText = $text;
        }

        return str_replace('-', '', trim($description));
    }
}
