<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class HiringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hr::hiring.index');
    }
}
