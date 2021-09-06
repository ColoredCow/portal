<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Maxslot extends Model
{   
    use SoftDeletes;
    protected $table = 'maxslots';
    protected $fillable = ['max_interviews_per_day',];
    protected $hidden = ['created_at', 'updated_at',];

    

    public static function getUserData()
    {
        $max_slot = DB::table('maxslots')->select('max_interviews_per_day')->latest('user_id')->first()->max_interviews_per_day;
        return $max_slot;
    }
}