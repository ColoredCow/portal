<?php

namespace Modules\HR\Entities;

use Auth;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserMeta extends Model
{
    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public static function getUserData()
    {
        $userId = Auth::user('id');
        $maxslots = DB::table('user_meta')->select('max_appointments_per_day')->where('user_id', $userId)->orderByDesc('created_at')->first();

        return $maxslots;
    }
}
