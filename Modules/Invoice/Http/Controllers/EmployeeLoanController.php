<?php
namespace Modules\Invoice\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Invoice\Entities\EmployeeLoan;
use Modules\Invoice\Services\EmployeeLoanService;

class EmployeeLoanController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct()
    {
        $this->service = new EmployeeLoanService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $requestParams = $request->all();
        $data = $this->service->index($requestParams);

        return view('invoice::employee-loan.index', $data);
    }

    /**
     * Show the form for creating the specified resource.
     */
    public function create(Request $request)
    {
        $requestParams = $request->all();
        $data = $this->service->create($requestParams);

        return view('invoice::employee-loan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $requestParams = $request->all();
        $data = $this->service->store($requestParams);

        return redirect(route('employee-loan.index'))->with('success', 'Loan created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EmployeeLoan $employeeLoan
     */
    public function edit(EmployeeLoan $employeeLoan)
    {
        $data = $this->service->edit($employeeLoan);

        return view('invoice::employee-loan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param EmployeeLoan $employeeLoan
     */
    public function update(Request $request, EmployeeLoan $employeeLoan)
    {
        $requestParams = $request->all();
        $data = $this->service->update($requestParams, $employeeLoan);

        return redirect()->back()->with('success', 'Loan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EmployeeLoan $employeeLoan
     */
    public function destroy(EmployeeLoan $employeeLoan)
    {
        $employeeLoan->delete();

        return redirect()->back()->with('success', 'Loan deleted successfully!');
    }
}
