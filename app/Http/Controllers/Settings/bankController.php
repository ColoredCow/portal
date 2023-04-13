<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;

class bankController extends Controller
{
    public function index()
    {
        return view('Settings.bankdetails');
    }
}
