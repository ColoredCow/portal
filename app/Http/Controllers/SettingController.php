<?php

namespace App\Http\Controllers;

use App\Helpers\ContentHelper;
use App\Http\Requests\SettingRequest;
use App\Models\HR\Round;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * List all settings for this module.
     *
     * @param string $module
     *
     * @return \Illuminate\View\View
     */
    public function index(String $module)
    {
        $this->authorize('view', Setting::class);

        $attr = self::getModuleSettings($module);
        $attr['settings'] = Setting::where('module', $module)->get()->keyBy('setting_key');

        return view("settings.$module")->with($attr);
    }

    /**
     * Update the settings in the request.
     *
     * @param SettingRequest $request
     * @param string         $module
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
                ['setting_value' => $value ? ContentHelper::editorFormat($value) : null]
            );
        }

        return redirect()->back()->with('status', 'Settings saved!');
    }

    /**
     * Returns settings based on the requested module.
     *
     * @param string $module
     *
     * @return array
     */
    protected static function getModuleSettings(String $module)
    {
        $attr = [];
        switch ($module) {
            case 'hr':
                $attr['rounds'] = Round::all();
                $attr['roundMailTypes'] = [
                    config('constants.hr.status.confirmed'),
                    config('constants.hr.status.rejected'),
                ];
                break;
        }

        return $attr;
    }
}
