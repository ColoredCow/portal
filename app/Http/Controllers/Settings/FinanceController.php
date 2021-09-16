<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    public function index()
    {
        return view('settings.finance.index');
    }
}
