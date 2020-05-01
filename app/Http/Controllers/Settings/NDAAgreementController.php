<?php

namespace App\Http\Controllers\Settings;

use App\Models\Setting;
use App\Models\HR\Round;
use App\Http\Controllers\Controller;

class NDAAgreementController extends Controller
{
    public function index()
    {
     
        $this->authorize('view', Setting::class);
        $attr['settings'] = Setting::where('module', 'agreement-nda')->get()->keyBy('setting_key');
        $attr['rounds'] = Round::all();
        $attr['roundMailTypes'] = [
            config('constants.hr.status.confirmed'),
            config('constants.hr.status.rejected'),
        ];
        return view('settings.agreement.nda.index')->with($attr);
    }
}
