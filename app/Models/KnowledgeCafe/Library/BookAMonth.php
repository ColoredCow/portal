<?php
namespace App\Models\KnowledgeCafe\Library;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

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

    public function scopeInCurrentYear($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ]);
    }

    public function scopeInCurrentMonth($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ]);
    }
}
