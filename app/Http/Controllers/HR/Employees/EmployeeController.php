<?php

namespace App\Http\Controllers\HR\Employees;

use App\Http\Controllers\Controller;
use App\Models\HR\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::active()->orderBy('name')->get();
        return view('hr.employees.index', compact('employees'));
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', compact('employee'));
    }
}
