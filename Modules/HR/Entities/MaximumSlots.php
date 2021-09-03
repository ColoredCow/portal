<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class MaximumSlots extends Model{

    public function getUserData(){

        $max_slot = DB::table('user_meta')->select('max_appointments_per_day')->orderBy('id', 'desc')->first();
        
        return $max_slot;
      }

}