<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfitabilityController extends Controller
{
    public function index()
    {
        $employeeEarningThreshold = Setting::where('setting_key', 'employee_earning_threshold')->value('setting_value');

        return view('settings.employee-earning-threshold.index', ['employeeEarningThreshold' => $employeeEarningThreshold]);
    }

    public function update(Request $request)
    {
        Setting::updateOrCreate(
            ['module' => 'setting', 'setting_key' => 'employee_earning_threshold'],
            ['setting_value' => $request->employee_earning_threshold]
        );

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
