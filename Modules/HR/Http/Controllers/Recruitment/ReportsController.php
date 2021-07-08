<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportsController extends Controller
{
    /**
     * Display the employee reports
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.recruitment.reports');
    }
}
