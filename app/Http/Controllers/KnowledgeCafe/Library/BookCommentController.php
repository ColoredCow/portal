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
            'body' => $request->comment,
            'commentable_id' => $book->id,
            'commentable_type' => Book::class
        ]);
        $book->comments()->save($comment);

        return response()->json($book->comments->last());
    }
}
