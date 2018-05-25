<?php

namespace App\Models\KnowledgeCafe\Library;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table = 'book_categories';
    protected $fillable = ['name']; 

    public function books() {
        return $this->belongsToMany(Book::class, 'library_book_category', 'book_category_id', 'library_book_id');
    }
}

