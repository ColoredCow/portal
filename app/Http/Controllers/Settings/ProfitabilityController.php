<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfitabilityController extends Controller
{
    public function index()
    {
        $profitabilityThreshold = Setting::where('setting_key', 'profitability_threshold_value')->value('setting_value');
        return view('settings.profitability-threshold-value.index', ['profitabilityThreshold' => $profitabilityThreshold]);
    }

    public function update(Request $request)
    {
        Setting::updateOrCreate(
            ['module' => 'setting', 'setting_key' => 'profitability_threshold_value'],
            ['setting_value' => $request->profitability_threshold_value]
        );

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
