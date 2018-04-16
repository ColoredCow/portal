<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(String $module)
    {
        $settings = Setting::all()->keyBy('setting_key');
        return view("settings.$module")->with(['settings' => $settings]);
    }

    public function update(SettingRequest $request, String $module)
    {
        $validated = $request->validated();

        foreach ($validated['setting_key'] as $key => $value) {
            $setting = Setting::updateOrCreate(
                ['module' => $module, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()->back()->with('status', 'Settings saved!');
    }
}
