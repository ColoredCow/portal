<?php

namespace Modules\Salary\Http\Controllers;

use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Salary\Entities\EmployeeSalary;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Salary\Entities\SalaryConfiguration;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(EmployeeSalary::class);
    }
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('salary::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function employee(Request $request, Employee $employee)
    {
        $this->authorize('view', EmployeeSalary::class);
        $salaryConfigs = SalaryConfiguration::formatAll();

        return view('salary::employee.index')->with([
            'employee'=> $employee,
            'salaryConfigs' => $salaryConfigs
        ]);
    }

    public function storeSalary(Request $request, Employee $employee)
    {
        EmployeeSalary::updateOrCreate(
            ['employee_id' => $employee->id],
            ['monthly_gross_salary' => ($request->grossSalary)]
        );

        return redirect()->back()->with('success', 'Gross Salary saved successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
    }

    public function salaryReport()
    {
        $employees = Employee::get();

        return view('salary::salary.index')->with('employees', $employees);
    }
}
