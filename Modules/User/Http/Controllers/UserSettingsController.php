<?php

namespace Modules\User\Http\Controllers;

use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Modules\HR\Entities\Maxslot;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserSettingsController extends ModuleBaseController
{
    public function index()
    {
        return view('user::user-settings.index');
    }
    

    public function storeData(Request $request)
    {
        DB::table('maxslots')->updateorInsert([
            'user_id' => Auth::user()->id,
            'max_interviews_per_day'=>$request->max_interviews_per_day,    
        ]);

        return redirect('/user/user-settings/hr')->with('status', 'Saved Successfully!');

    }

      public function save()
    {   
        $maxinterviews=DB::table('maxslots')->select('max_interviews_per_day')->orderBy('id', 'DESC')->first();
        
        return view('user::user-settings.hr-save');//->with('maxinterviews',$maxinterviews);
    }
    
    // public function update(Request $request)
    // {
    //      DB::table('maxslots')->update([
    //         'user_id' => Auth::user()->id,
    //         'max_interviews_per_day'=>$request->max_interviews_per_day,    
    //     ]);

    //      return redirect('/user/user-settings/hr')->with('status', 'Saved Successfully!');
    // }

}
