<?php

namespace App\Models\KnowledgeCafe\Library;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'library_books';
    protected $fillable = ['title', 'author', 'categories', 'isbn', 'thumbnail', 'readable_link'];

    public static function _create($data) {
        $ISBN = isset ($data['isbn']) ? $data['isbn'] : null;
        return ($ISBN && self::where('isbn', $ISBN )->first()) ? true : self::create($data);
    }  
}

