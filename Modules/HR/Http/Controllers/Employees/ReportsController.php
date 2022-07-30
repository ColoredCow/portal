<?php

namespace Modules\HR\Http\Controllers\Employees;

use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    /**
     * Display the employee reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.employees.reports');
    }
}
