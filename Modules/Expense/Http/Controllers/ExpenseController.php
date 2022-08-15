<?php

namespace Modules\Expense\Http\Controllers;

use Illuminate\Routing\Controller;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('expense::index');
    }
}
