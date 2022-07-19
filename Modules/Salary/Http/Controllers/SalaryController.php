<?php

namespace Modules\Salary\Http\Controllers;

use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

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

    public function employee()
    {
        $employees = Employee::get();

        return view('salary::employee.index')->with('employees', $employees);
    }

    public function saveSalary(Request $req)
    {
        dd($req->grossSalary);
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
