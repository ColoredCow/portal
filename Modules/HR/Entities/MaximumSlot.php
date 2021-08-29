<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class MaximumSlot extends Model
{
    protected $fillable = ['max_appointments_per_day','user_id'];

    protected $table = 'user_meta';
}