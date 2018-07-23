<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\HR\Round;

class HRController extends Controller
{
    public function index()
    {
        $attr['rounds'] = Round::all();
        $attr['roundMailTypes'] = [
            config('constants.hr.status.confirmed'),
            config('constants.hr.status.rejected'),
        ];
        return view('settings.hr.index')->with($attr);
    }
}
