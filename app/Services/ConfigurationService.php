<?php

namespace App\Services;

use App\Models\Setting;

class ConfigurationService
{
    public function index()
    {
        $ConfigsValue = Setting::query()
            ->where('setting_key', 'employee_earning_threshold')
            ->orWhere('setting_key', 'contract_endDate_threshold')
            ->get();
            
        return $ConfigsValue;
    }
    public function updateSetting($settings)
    {
        foreach ($settings as $settingKey => $settingValue) {
            Setting::updateOrCreate(
                ['module' => 'setting', 'setting_key' => $settingKey],
                ['setting_value' => $settingValue]
            );
        }
    }
}
