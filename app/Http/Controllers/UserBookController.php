<?php

namespace App\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;
use App\Models\KnowledgeCafe\Library\Book;
use Illuminate\Support\Facades\DB;

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
        $userBookReader = DB::table('book_readers')->select('*')->where('user_id', auth()->user()->id)->first()->library_book_id;
        $readBooks = Book::where('id', $userBookReader)->get();
        $userBookBorrower = DB::table('book_borrower')->where('user_id', auth()->user()->id)->first()->library_book_id;
        $borrowedBooks = Book::where('id', $userBookBorrower)->get();

        return view('knowledgecafe.library.books.user-books-details', ['user'=>$user, 'readBooks'=>$readBooks, 'borrowedBooks'=>$borrowedBooks]);
    }
}
