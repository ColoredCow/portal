<?php

namespace Modules\Salary\Http\Controllers;

use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Salary\Entities\EmployeeSalary;

class SalaryController extends Controller
{
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
        return view('salary::employee.index')->with('employee', $employee);
    }

    public function storeSalary(Request $request, Employee $employee)
    {
        EmployeeSalary::updateOrCreate(
            ['employee_id' => $employee->user_id],
            ['gross_salary' => $request->grossSalary]
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
}
