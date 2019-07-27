<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KnowledgeCafe\Library\Book;

class BookCommentController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        $book->comments()->save($comment);
        return response()->json();
    }
}
