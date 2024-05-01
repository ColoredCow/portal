<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\ConfigurationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConfigurationController extends Controller
{

    use AuthorizesRequests;
    protected $service;

    public function __construct(ConfigurationService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $configsData = $this->service->index();

        return view('settings.configuration-threshold.index', [
            'configsData' => $configsData,
        ]);
    }
    public function update(Request $request)
    {
        $this->service->updateSetting([
            'employee_earning_threshold' => $request->employee_earning_threshold,
            'contract_endDate_threshold' => $request->contract_endDate_threshold
        ]);

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
