<?php

namespace Modules\Salary\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Salary\Services\SalaryCalculationService;

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
        return view('salary::create');
    }

    public function employee()
    {
        $user = User::find(4);
        $salaryCalculation = new SalaryCalculationService(28169);

        return view('salary::employee.index', ['user' => $user, 'salaryCalculation' => $salaryCalculation]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return view('salary::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('salary::edit');
    }

}
