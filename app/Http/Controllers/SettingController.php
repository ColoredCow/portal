<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('setting_key');
        return view('settings')->with(['settings' => $settings]);
    }

    public function update(SettingRequest $request)
    {
        $validated = $request->validated();

        foreach ($validated['setting_key'] as $key => $value) {
            $setting = Setting::updateOrCreate(
                ['module' => $validated['module'], 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()->back();
    }
}
