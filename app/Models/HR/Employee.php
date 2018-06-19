<?php

namespace App\Models\HR;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    protected $dates = ['joined_on'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function getEmploymentDurationAttribute()
    {
        if (is_null($this->user_id)) {
            return null;
        } else {
            return $this->joined_on->diffForHumans(Carbon::now(), true, true);
        }
        return $duration;
    }
}
