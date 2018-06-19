<?php

namespace App\Models\HR;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('user_id');
    }
}
