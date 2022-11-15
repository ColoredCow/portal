<?php

namespace App\Services;

use GuzzleHttp\Client;
use Vision\Feature;
use Vision\Request\Image\LocalImage;
use Vision\Vision;
use Illuminate\Support\Facades\Mail;
use Modules\User\Entities\User;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

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

        if (!isset($book['items'])) {
            $res = $client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q=ISBN:' . $isbn, [
                'timeout' => 5.0,
            ]);

            $book = json_decode($res->getBody(), true);
        }

        if (!isset($book['items'])) {
            return 'please try again';
        }

        return $book;
    }

    /**
     * Fetch ISBN form book image.
     *
     * @param mixed $file
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
    public function SendMailUncommentedUsers()
    {
        $comment_id = comment::pluck('commentable_id');
        $user_id = DB::table('book_readers')->whereNotIn('library_book_id', $comment_id)->pluck('user_id');
        $book_id = DB::table('book_readers')->where('user_id', $user_id)->pluck('library_book_id');
        $book_title = Book::wherenull('deleted_at')->orwhere('id', $book_id)->pluck('title')->toArray();
        $user_name = USER::wherenull('deleted_at')->orwhere('id', $user_id)->pluck('name')->toArray();
        $Id = [];
        foreach (array_unique($user_name) as $key => $values) {
            $temp = array_values(array_intersect_key($book_title, array_intersect($user_name, [$values])));
            if (count($temp) > 1) {
                $Id[$values] = $temp;
            } else {
                $Id[$values] = $temp[0];
            }
        }

        foreach ($Id as $key => $value) {
            $email = User::where('name', $key)->select('email')->pluck('email')->toArray();
            foreach ($email as $mail) {
                $data = ['name' => $key, 'key1' => $value];
                Mail::send('emails.mailsend', $data, function ($message) use ($mail) {
                    $message->to($mail);
                    $message->subject('Feedback_on_Book');
                });
            }
        }

        return 0;
    }
}
