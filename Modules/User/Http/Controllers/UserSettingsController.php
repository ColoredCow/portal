<?php

namespace Modules\User\Http\Controllers;

use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Modules\HR\Entities\Maxslot;
use Carbon\Carbon;
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
        DB::table('maxslots')->Insert([
            'user_id' => Auth::user()->id,
            'max_interviews_per_day'=>$request->max_interviews_per_day,
            'created_at'=>  \Carbon\Carbon::now(),
        ]);

        return redirect('/user/user-settings/hr')->with('status', 'Saved Successfully!');

    }

      public function save()
    {
        $maxinterviews = new Maxslot;
    
        return view('user::user-settings.hr-save', compact('maxinterviews'));
    }

}
