<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class bankController extends Controller
{
    public function index()
    {
        return view('Settings.bank-details');
    }
}
