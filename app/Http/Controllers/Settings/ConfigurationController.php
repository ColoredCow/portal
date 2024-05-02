<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    use AuthorizesRequests;
    protected $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $settingKeys = config('constants.module-settings.config-variable');
        $getSettings = $this->service->getThresholdValue($settingKeys);

        return view('settings.configuration-threshold.index', [
            'getSettings' => $getSettings,
        ]);
    }
    public function update(Request $request)
    {
        $this->service->updateSetting([
            'employee_earning_threshold' => $request->employee_earning_threshold,
            'contract_end_date_threshold' => $request->contract_end_date_threshold,
        ]);

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
