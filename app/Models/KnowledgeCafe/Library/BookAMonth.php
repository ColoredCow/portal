<?php

namespace App\Models\KnowledgeCafe\Library;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BookAMonth extends Model
{
    protected $guarded = [];

    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'library_book_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
