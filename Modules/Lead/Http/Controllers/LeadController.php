<?php

namespace Modules\Lead\Http\Controllers;

use Illuminate\Routing\Controller;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lead::index');
    }
}
