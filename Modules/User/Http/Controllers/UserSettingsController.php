<?php

namespace Modules\User\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserSettingsController extends ModuleBaseController
{
    public function index()
    {
        return view('user::user-settings.index');
    }

    public function update(Request $request)
    {
        Auth::user()->meta()->updateOrCreate(
            ['meta_key' => 'max_interviews_per_day'],
            ['meta_value' => $request->max_interviews_per_day]
        );

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
