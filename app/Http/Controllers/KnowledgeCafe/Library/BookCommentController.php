<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\Comment;

class BookCommentController extends Controller
{
    public function store(Request $request, Book $book) {
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);

        $book->comments()->save($comment);
        return response()->json();
    }
}
