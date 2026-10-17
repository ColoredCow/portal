<?php

namespace App\Models\KnowledgeCafe\Library;

use Database\Factories\BookCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'book_categories';
    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'library_book_category', 'book_category_id', 'library_book_id');
    }

    protected static function newFactory()
    {
        return BookCategoryFactory::new();
    }
}
