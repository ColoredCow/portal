<?php

namespace App\Http\Controllers\HR\Employees;

use App\Http\Controllers\Controller;
use Modules\HR\Entities\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
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

    /**
     * Display the project details of an Employee.
     *
     * @param  Employee $employee
     */
    public function showProjects(Employee $employee)
    {
        $employee->load('projects');

        return view('hr.employees.projects', compact('employee'));
    }

    public function showEmployeeProjects(Employee $employee)
    {
        return view('hr.employees.employee-details')->with(['employee' => $employee]);
    }
}
