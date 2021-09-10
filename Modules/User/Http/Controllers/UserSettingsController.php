<?php

namespace Modules\User\Http\Controllers;

use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Modules\HR\Entities\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Foundation\Http\FormRequest;

class UserSettingsController extends ModuleBaseController
{
    public function index()
    {
        // $user= User::find(2);
        // dd($user);
        // dd($user->maxslots->max_interviews_per_day)
        // dd($user->maxSlots ?? config);
        return view('user::user-settings.index');
    }    

    public function storeData(Request $request)
    {
        
        DB::table('user_meta')->Insert([
            'user_id' => Auth::user()->id,
            'max_interviews_per_day'=>$request->max_interviews_per_day,
            'created_at'=>  \Carbon\Carbon::now(),
        ]);

        return redirect('/user/user-settings')->with('status', 'Saved Successfully!');

    }

      public function update(Request $request)
    {
        
         DB::table('user_meta')->updateOrInsert(
            ['user_id' => Auth::user()->id,],

            ['max_interviews_per_day'=>$request->max_interviews_per_day,]
            );

           return redirect('/user/user-settings')->with('status', 'Saved Successfully!');
    }
    
     public function save()
    {
        $maxinterviews = new UserMeta;
    
        return view('user::user-settings.hr-save', compact('maxinterviews'));
    }

}
