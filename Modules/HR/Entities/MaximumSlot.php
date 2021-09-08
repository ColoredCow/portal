<?php

namespace Modules\HR\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserMeta extends Model
{
    public function user()
    {
        return  $this->belongsTo (User::class);
    }

    public static function getUserData()
    {
        $maxslots=DB::table('user_meta')->select('max_appointments_per_day')->where('user_id', 'users.id')->orderByDesc('created_at')->first();
        
        return $maxslots;

    }
}
