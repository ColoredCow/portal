<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class PageVisit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'page_path', 'visit_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
