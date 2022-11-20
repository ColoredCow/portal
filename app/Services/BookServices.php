<?php

namespace App\Services;

use GuzzleHttp\Client;
use Vision\Feature;
use Vision\Request\Image\LocalImage;
use Vision\Vision;
use Illuminate\Support\Facades\Mail;
use Modules\User\Entities\User;
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
        $user_table = DB::table('book_readers')->whereNotIn('library_book_id', $comment_id)->distinct()->pluck('user_id');
        $user_id = USER::wherenull('deleted_at')->orwhere('id', $user_table)->get()->toArray();

        foreach ($user_id as $user) {
            $each_user_books = [];
            $user_book = USER::find($user['id'])->books;
            foreach ($user_book as $book) {
                array_push($each_user_books, [$book->title]);
            }

            foreach ($user_id as $user_details) {
                $email = $user_details['email'];
                $reader_name = $user_details['name'];
                $data = ['name' => $reader_name, 'allbook' => $each_user_books];
                Mail::send('emails.mailsend', $data, function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Feedback_on_Book');
                });
            }
        }

        return 0;
    }
}
