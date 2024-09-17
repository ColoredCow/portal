<?php

namespace App\Models\KnowledgeCafe\Library;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Operations\Entities\OfficeLocation;

class BookLocation extends Model
{
    use SoftDeletes;

    protected $table = 'library_book_location';
    protected $fillable = ['book_id', 'office_location_id', 'number_of_copies'];
    protected $dates = ['deleted_at'];

    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'book_id');
    }

    public function location()
    {
        return $this->hasOne(OfficeLocation::class, 'id', 'office_loaction_id');
    }
}