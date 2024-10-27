<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $guarded = [];
}
