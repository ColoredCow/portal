<?php

namespace App\Models\KnowledgeCafe\Library;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'library_books';
    protected $fillable = ['title', 'author', 'isbn', 'thumbnail', 'readable_link', 'self_link', 'number_of_copies'];
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(BookCategory::class, 'library_book_category', 'library_book_id', 'book_category_id');
    }

    public static function getList($filteredString = false)
    {
        return self::with(['categories', 'readers'])
            ->where(function ($query) use ($filteredString) {
                    if($filteredString) {
                        $query->where('title', 'LIKE', "%$filteredString%")
                            ->orWhere('author', 'LIKE', "%$filteredString%")
                            ->orWhere('isbn', 'LIKE', "%$filteredString%");
                    }

                ($filteredString) ?  : '';
            })
            ->withCount('readers')
            ->orderBy('readers_count', 'desc')
            ->get();
    }

    public static function getByCategoryName($categoryName)
    {
        if (!$categoryName) {
            return false;
        }

        return self::whereHas('categories', function ($query) use ($categoryName) {
            $query->where('name', $categoryName);
        })->get();
    }

    public function readers()
    {
        return $this->belongsToMany(User::class, 'book_readers', 'library_book_id', 'user_id');
    }

    public function markAsRead()
    {
        $this->readers()->attach(auth()->user());
        $this->wishers()->detach(auth()->user());
        return true;
    }

    public function markAsUnRead()
    {
        $this->readers()->detach(auth()->user());
        return true;
    }

    public function markBook($read)
    {
        return ($read) ? $this->markAsRead() : $this->markAsUnRead();
    }

    public static function getRandomUnreadBook()
    {
        return self::whereDoesntHave('readers', function ($query) {
            $query->where('id', auth()->id());
        })->whereDoesntHave('wishers', function ($query) {
            $query->where('id', auth()->id());
        })->inRandomOrder()
            ->first();
    }

    public function wishers()
    {
        return $this->belongsToMany(User::class, 'book_wishlist', 'library_book_id', 'user_id');
    }

    public function addToWishlist()
    {
        $this->wishers()->attach(auth()->user());
        return true;
    }

    public function getTotalBooksCountAttribute($value)
    {
        return self::count();
    }

    public function getThumbnailBySize($size = 'normal')
    {
        switch ($size) {
            case 'medium':
                return str_replace_first('zoom=1', 'zoom=2', $this->thumbnail);
                break;

            case 'large':
                return str_replace_first('zoom=1', 'zoom=3', $this->thumbnail);
                break;

            default:
                return $this->thumbnail;
        }
    }
}
