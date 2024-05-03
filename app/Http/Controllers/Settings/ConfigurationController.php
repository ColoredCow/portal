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
        $settings = $this->service->getSettings($settingKeys);

        return view('settings.config-variables.index', [
            'settings' => $settings,
        ]);
    }

    public function updateAll(Request $request)
    {
        $this->service->updateSettings([
            'employee_earning_threshold' => $request->employee_earning_threshold,
            'contract_end_date_threshold' => $request->contract_end_date_threshold,
        ]);

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
