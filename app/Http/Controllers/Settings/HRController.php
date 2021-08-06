<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\ContentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;
use Modules\HR\Entities\Round;

class HRController extends Controller
{
    public function index()
    {
        $this->authorize('view', Setting::class);
        $attr['settings'] = Setting::where('module', 'hr')->get()->keyBy('setting_key');
        $attr['rounds'] = Round::all();
        $attr['roundMailTypes'] = [
            config('constants.hr.status.confirmed'),
            config('constants.hr.status.rejected'),
        ];

        return view('settings.hr.index')->with($attr);
    }
    public function update(SettingRequest $request)
    {
        $this->authorize('update', Setting::class);
        $validated = $request->validated();
        foreach ($validated['setting_key'] as $key => $value) {
            $setting = Setting::updateOrCreate(
                ['module' => 'hr', 'setting_key' => $key],
                ['setting_value' => $value ? ContentHelper::editorFormat($value) : null]
            );
        }

        return redirect()->back()->with('status', 'Settings saved!');
    }
}
