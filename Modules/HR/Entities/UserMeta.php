<?php

namespace Modules\HR\Entities;

use Modules\User\Entities\User;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Modules\AppointmentSlots\Services\AppointmentSlotsService;

class UserMeta extends Model
{
    //use SoftDeletes;
    protected $table = 'user_meta';
    protected $fillable = ['max_interviews_per_day',];
    //protected $hidden = ['created_at', 'updated_at',];

    public function user()
    {
        return  $this->belongsTo (User::class);
    }

     public static function getUserData($data)

    {

        // $id = json_decode(decrypt($data['id']), true);
        // $decryptedParams = json_decode(decrypt($id), true);
        // $userId = $decryptedParams['user_id'];
        // $user=User::decrpyt()->request()->user('id');
        // dd($user);
        //$userId= User::select('id')->first()->id;
        // $user = Maxslot::select('user_id')->first()->user_id;
        // if($userId == $user)
        // {
        //     $max_slots = Maxslot::with('user')->select('max_interviews_per_day')->first()->max_interviews_per_day;
        //     return($max_slots);
        // }
    }    

    
}