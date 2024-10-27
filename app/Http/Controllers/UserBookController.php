<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;

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
}
