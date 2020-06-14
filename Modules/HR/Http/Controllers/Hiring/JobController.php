<?php

namespace Modules\HR\Http\Controllers\Hiring;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('hr::index');
    }
}
