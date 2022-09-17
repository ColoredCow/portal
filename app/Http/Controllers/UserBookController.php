<?php

namespace App\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;
use App\Services\BookServices;

class UserBookController extends Controller
{
    public function index()
    {
        $userId = request('user_id', null);
        $user = $userId ? User::find($userId) : Auth::user();

        return $user->books;
    }

    public function booksInWishlist()
    {
        $userId = request('user_id', null);
        $user = $userId ? User::find($userId) : Auth::user();

        return $user->booksInWishlist;
    }
    public function userBookDetails(User $user)
    {
        $books = (new BookServices)->getReaderDetails();

        return view('knowledgecafe.library.books.user-books-details', ['user'=>$user, 'books'=>$books]);
    }
}
