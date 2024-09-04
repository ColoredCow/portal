<?php

namespace Modules\User\Entities;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $guarded = [];

    public function getAgeAttribute()
    {
        $dob = Carbon::parse($this->date_of_birth);
        return $dob->age;
    }
}
