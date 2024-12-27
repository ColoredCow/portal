<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeCafe\Library\Book;
use Google_Client;
use Google_Service_Directory;
use Illuminate\Http\Request;
use Modules\User\Entities\UserMeta;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $unreadBook = session('disable_book_suggestion') ? null : Book::getRandomUnreadBook();

        return view('home')->with([
            'book' => $unreadBook,
        ]);
    }
}
