<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ProfitabilityController extends Controller
{
    public function index()
    {
        return view('settings.profitability-threshold-value.index');
    }

    public function update(Request $request)
    {
        Auth::user()->meta()->updateOrCreate(
            ['meta_key' => 'profitability_threshold_value'],
            ['meta_value' => $request->profitability_threshold_value]
        );

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
