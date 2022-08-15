<?php

namespace Modules\Expense\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Client\Entities\Country;

class RecurringExpenseController extends Controller
{
    public function index() {
        return view('expense::recurring.index');
    }

    public function create() {
        return view('expense::recurring.create', ['countries' => Country::all()]);
    }
}
