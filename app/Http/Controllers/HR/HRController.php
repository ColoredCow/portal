<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

class HRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.index');
    }
}
