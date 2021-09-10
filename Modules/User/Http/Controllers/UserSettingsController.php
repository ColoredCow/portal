<?php

namespace Modules\User\Http\Controllers;

use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Modules\User\Entities\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Foundation\Http\FormRequest;

class UserSettingsController extends ModuleBaseController
{
    public function index()
    {
        return view('user::user-settings.index');
    }

    public function update(Request $request)
    {
        DB::table('user_meta')->updateOrInsert(
            ['user_id' => Auth::user()->id,],
            ['max_interviews_per_day'=>$request->max_interviews_per_day,]
        );

        return redirect('/user/user-settings')->with('status', 'Saved Successfully!');
    }
}
