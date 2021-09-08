<?php
namespace Modules\User\Http\Controllers;

use DB;
use Auth;
use Modules\HR\Entities\UserMeta;
use Illuminate\Http\Request;

class UserSettingsController extends ModuleBaseController
{
    public function index()
    {
        return view('user::user-settings.index');
    }

    public function storeData(Request $request)
    {
        DB::table('user_meta')->insert([
            'user_id' => Auth::user()->id,
            'max_appointments_per_day'=>$request->max_appointments_per_day,
      ]);

        return redirect('/user/user-settings/hr')->with('status', 'Saved Successfully!');
    }

    public function save()
    {
        $maxinterviews = new UserMeta;

        return view('user::user-settings.hr-save', compact('maxinterviews'));
    }
}
