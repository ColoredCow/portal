<?php

namespace App\Models\KnowledgeCafe\Library;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'library_books';
    protected $fillable = ['title', 'author', 'categories', 'isbn', 'thumbnail', 'readable_link', 'self_link'];

    public static function _create($data) {
        $ISBN = isset ($data['isbn']) ? $data['isbn'] : null;
        return self::firstOrCreate(['isbn' => $ISBN], $data);
    }

    public function _update($data) {
        if(isset($data['categories'])) {
            $categories = array_pluck($data['categories'], 'id');
            $this->categories()->sync($categories);
            return true;
        }
        return false;
    }
    
    public function categories() {
        return $this->belongsToMany(BookCategory::class, 'library_book_category', 'library_book_id', 'book_category_id');
    }
}

