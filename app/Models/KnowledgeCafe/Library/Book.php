<?php

namespace App\Models\KnowledgeCafe\Library;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Book extends Model
{
    use SoftDeletes;
    
    protected $table = 'library_books';
    protected $fillable = ['title', 'author', 'categories', 'isbn', 'thumbnail', 'readable_link', 'self_link'];
    protected $dates = ['deleted_at'];

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

    public function readers() {
        return $this->belongsToMany(User::class, 'book_readers', 'library_book_id', 'user_id');
    }

    public function markBook($read) {
         $result = ($read) ? $this->readers()->attach(auth()->user()) 
                  : $this->readers()->detach(auth()->user());

        return true;
    }

    public static function getRandomUnreadBook() {
        return self::whereDoesntHave('readers', function ($query) {
            $query->where('id', auth()->id());
        })->get()->random();
    }
}

