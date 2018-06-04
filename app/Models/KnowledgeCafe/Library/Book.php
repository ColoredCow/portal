<?php

namespace App\Models\KnowledgeCafe\Library;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'library_books';
    protected $fillable = ['title', 'author', 'categories', 'isbn', 'thumbnail', 'readable_link', 'self_link'];
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(BookCategory::class, 'library_book_category', 'library_book_id', 'book_category_id');
    }

    public static function getList($filteredString = false)
    {
        return self::with('categories')
                ->orderBy('title')
                ->where(function ($query) use ($filteredString) {
                        ($filteredString) ? $query->where('title', 'LIKE', "%$filteredString%") : '';
                })->paginate(config('constants.pagination_size'));
    }

    public static function getByCategoryName($categoryName) {
        if(!$categoryName) {
            return false;
        }

        return self::whereHas('categories', function ($query) use($categoryName) {
            $query->where('name', $categoryName);
        })->get();

    }
}
