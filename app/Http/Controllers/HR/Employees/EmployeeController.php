<?php

namespace App\Http\Controllers\HR\Employees;

use App\Http\Controllers\Controller;
use Modules\HR\Entities\Employee;
use App\Contracts\EmployeeServiceContract;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $service;

    public function __construct(EmployeeServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 'active';
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();

        $employees = Employee::active()->orderBy('name')->get();

        return view('hr.employees.index', $this->service->index($filters, $status), compact('employees'));
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', ['employee' => $employee]);
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
}
