<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $employeeEarningThreshold = Setting::where('setting_key', 'employee_earning_threshold')->value('setting_value');
        $endDateAlert =  Setting::where('setting_key', 'contract_endDate_threshold')->value('setting_value');

        return view('settings.configuration-threshold.index', [
            'employeeEarningThreshold' => $employeeEarningThreshold,
            'endDateAlert' => $endDateAlert,
        ]);
    }
    public function update(Request $request)
    {
        $this->updateSetting('employee_earning_threshold', $request->employee_earning_threshold);
        $this->updateSetting('contract_endDate_threshold', $request->contract_endDate_threshold);

        return redirect()->back()->with('status', 'Saved Successfully!');
    }

    private function updateSetting($settingKey, $settingValue)
    {
        Setting::updateOrCreate(
            ['module' => 'setting', 'setting_key' => $settingKey],
            ['setting_value' => $settingValue]
        );
    }
}
