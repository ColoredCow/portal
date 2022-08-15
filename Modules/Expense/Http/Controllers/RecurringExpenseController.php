<?php

namespace Modules\Expense\Http\Controllers;

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
    
    public function index() {
        return view('expense::recurring.index', [
            'recurringExpenses' => $this->service->index()
        ]);
    }

    public function create() {
        return view('expense::recurring.create', ['countries' => Country::all()]);
    }

    public function store() {
        // ToDo:: we need to add validations here.
        $this->service->store(request()->all());
        return redirect()->route('expense.recurring.index');
    }
}
