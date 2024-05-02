<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function getThresholdValue($setting_keys)
    {
        $getSettings = Setting::query()
            ->whereIn('setting_key', $setting_keys)
            ->get();

        return $getSettings;
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
