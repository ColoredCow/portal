<?php

namespace Modules\Salary\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Salary\Services\SalaryCalculationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SalaryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Salary::class);
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
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
    }
}
