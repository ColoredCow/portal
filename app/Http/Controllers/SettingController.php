<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Models\HR\Round;

class SettingController extends Controller
{
    /**
     * List all settings for this module
     * @param  String $module
     *
     * @return \Illuminate\View\View
     */
    public function index(String $module)
    {
        $this->authorize('view', Setting::class);

        $settings = Setting::where('module', $module)->get()->keyBy('setting_key');
        return view("settings.$module")->with([
            'settings' => $settings,
            'rounds' => Round::all(),
        ]);
    }

    /**
     * Update the settings in the request
     * @param  SettingRequest $request
     * @param  String         $module
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, String $module)
    {
        $this->authorize('update', Setting::class);

        $validated = $request->validated();

        foreach ($validated['setting_key'] as $key => $value) {
            $setting = Setting::updateOrCreate(
                ['module' => $module, 'setting_key' => $key],
                ['setting_value' => ContentHelper::editorFormat($value)]
            );
        }

        return redirect()->back()->with('status', 'Settings saved!');
    }
}
