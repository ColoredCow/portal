<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    protected $casts = [
        'created_at' => 'datetime: D F d',
    ];

    protected $with = ['user'];
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
