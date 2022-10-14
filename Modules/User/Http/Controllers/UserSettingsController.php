<?php

namespace Modules\User\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Modules\HR\Entities\Employee;
use Modules\User\Entities\User;

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
    public function addStaffType(Request $request)
    {
        $chosenEmployee = User::find($request->id)->employee;
        $chosenEmployee->staff_type = $request->typeOfStaff;
        $chosenEmployee->save();
    }
}
