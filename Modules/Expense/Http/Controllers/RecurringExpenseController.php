<?php

namespace Modules\Expense\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Country;
use Modules\Expense\Services\RecurringExpenseService;

class RecurringExpenseController extends Controller
{
    protected $service;

    public function __construct(RecurringExpenseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('expense::recurring.index', [
            'recurringExpenses' => $this->service->index()
        ]);
    }

    public function create()
    {
        return view('expense::recurring.create', ['countries' => Country::all()]);
    }

    public function store(Request $request)
    {
        // ToDo:: we need to add validations here.
        $validated = $request->validate([
            'name' => 'required',
            'frequency' => 'required',
            'initial_due_date' => 'required',
            'currency' =>  'required',
            'amount' => 'required',
           

        ]);
   

        $this->service->store(request()->all());
       
        return redirect()->route('expense.recurring.index');
    }

    public function edit($id)
    {
        return view('expense::recurring.edit', ['recurringExpense' => $this->service->edit($id), 'countries' => Country::all()]);
    }

    public function update($id, Request $request)
    {
        // ToDo:: we need to add validations here.
        $this->service->update($id, request()->all());

        return redirect()->route('expense.recurring.index');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);

        return redirect()->route('expense.recurring.index');
    }
}
