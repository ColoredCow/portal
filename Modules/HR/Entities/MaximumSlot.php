<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaximumSlot extends Model
{
    public static function getUserData()
    {
        $max_slot = DB::table('user_meta')->select('max_appointments_per_day')->orderBy('id', 'desc')->first()->max_appointments_per_day;

        return $max_slot;
    }
}
