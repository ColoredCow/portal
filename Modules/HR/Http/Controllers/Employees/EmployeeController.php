<?php

namespace Modules\HR\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Modules\HR\Entities\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $filters = $filters ?: $this->service->defaultFilters();

        return view('hr.employees.index', $this->service->index($filters));
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
