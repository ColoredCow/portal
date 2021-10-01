<?php

namespace Modules\User\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Modules\User\Entities\UserMeta;

class UserSettingsController extends ModuleBaseController
{
    public function index()
    {
        return view('user::user-settings.index');
    }
    public function update(Request $request)
    {
        UserMeta::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['max_interviews_per_day' => $request->max_interviews_per_day]
        );

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
