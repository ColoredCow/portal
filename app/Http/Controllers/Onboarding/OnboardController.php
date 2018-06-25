<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;

class OnboardController extends Controller
{
    public function index()
    {
        return view('onboarding.index');
    }
}
