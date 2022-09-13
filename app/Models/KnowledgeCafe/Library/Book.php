<?php

namespace App\Models\KnowledgeCafe\Library;

use Modules\User\Entities\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'library_books';
    protected $fillable = ['title', 'author', 'isbn', 'thumbnail', 'readable_link', 'self_link', 'number_of_copies', 'on_kindle'];
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(BookCategory::class, 'library_book_category', 'library_book_id', 'book_category_id');
    }

    public static function getList($filteredString = false)
    {
        $query = self::with(['categories', 'readers', 'borrowers','comments']);

        return $query
            ->where(function ($query) use ($filteredString) {
                if ($filteredString) {
                    $query->where('title', 'LIKE', "%$filteredString%")
                        ->orWhere('author', 'LIKE', "%$filteredString%")
                        ->orWhere('isbn', 'LIKE', "%$filteredString%");
                }
            })
            ->withCount(['readers','comments'])
            ->orderBy('readers_count', 'desc')
            ->get();
    }

    public function scopeKindle($query)
    {
        return $query->where('on_kindle', true);
    }

    public function scopeNotOnKindle($query)
    {
        return $query->where('on_kindle', false);
    }

    public static function getByCategoryName($categoryName)
    {
        if (! $categoryName) {
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

    public function removeFromWishlist()
    {
        $this->wishers()->detach(auth()->user());

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

            case 'large':
                return str_replace_first('zoom=1', 'zoom=3', $this->thumbnail);

            default:
                return $this->thumbnail;
        }
    }

    public function borrowers()
    {
        return $this->belongsToMany(User::class, 'book_borrower', 'library_book_id', 'user_id');
    }

    public function markAsBorrowed()
    {
        $this->borrowers()->attach(auth()->user());
    }

    public function putBackToLibrary()
    {
        $this->borrowers()->detach(auth()->user());
    }

    public function selectBookForCurrentMonth()
    {
        return BookAMonth::create([
            'user_id' => auth()->user()->id,
            'library_book_id' => $this->id,
        ]);
    }

    public function unselectBookFromCurrentMonth()
    {
        $startOfYear = today()->startOfYear();
        $endOfYear = today()->endOfYear();

        return BookAMonth::where([
            'user_id' => auth()->user()->id,
            'library_book_id' => $this->id,
        ])->whereBetween('created_at', [$startOfYear, $endOfYear])->first()->delete();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function bookAMonths()
    {
        return $this->hasMany(BookAMonth::class, 'library_book_id');
    }
}
