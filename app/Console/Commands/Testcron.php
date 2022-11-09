<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\User\Entities\User;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;


class Testcron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail to all users by runnig this command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $comment_id = comment::pluck('commentable_id');
        $user_id = DB::table('book_readers')->whereNotIn("library_book_id", $comment_id)->pluck('user_id');
        $book_id = DB::table('book_readers')->where('user_id', $user_id)->pluck('library_book_id');
        $book_title = Book::wherenull('deleted_at')->orwhere('id', $book_id)->pluck('title')->toArray();
        $user_name = USER::wherenull('deleted_at')->orwhere('id', $user_id)->pluck('name')->toArray();
        $yamlMap = [];
        foreach (array_unique($user_name) as $key => $ykey) {
            $temp = array_values(array_intersect_key($book_title, array_intersect($user_name, [$ykey])));
            if (count($temp) > 1) {
                $yamlMap[$ykey] = $temp;
            } else {
                $yamlMap[$ykey] = $temp[0];
            }
        }

        foreach ($yamlMap as $key => $value) {
            $email = User::where('name', $key)->select('email')->pluck('email')->toArray();
            foreach ($email as $mail) {
                $data = ['name' => $key, 'key1' => $value];
                Mail::send('emails.mailsend', $data, function ($message) use ($mail) {
                    $message->to($mail);
                    $message->subject('hello-world');
                });
            }
        }
        return 0;
    }
}
