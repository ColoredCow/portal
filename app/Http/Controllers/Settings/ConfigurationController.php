<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\ConfigurationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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
        $ThresholdValues = $this->service->getThresholdValue();

        return view('settings.configuration-threshold.index', [
            'ThresholdValues' => $ThresholdValues,
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
