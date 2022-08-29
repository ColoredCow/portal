<?php

namespace Modules\Expense\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Entities\Expense;
use Modules\Expense\Entities\ExpenseFiles;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenseData = DB::table('expense')->get()->toArray();
        return view('expense::index')->with('expenses', $expenseData);
    }
    
    public function create()
    {
        return view('expense::expenses.create');
    }

    public function store(Request $request)
    {
        $expense = new Expense();
        $expensefile = new ExpenseFiles();

        $expense->name = $request['name'];
        $expense->amount = $request['amount'];
        $expense->status = $request['status'];
        $expense->paid_on = $request['paid_on'];
        $expense->category = $request['category'];
        $expense->location = $request['location'];
        $expense->uploaded_by = $request['uploaded_by'];
        $expense->deleted_at = $request['deleted_at'];
        $expensefile->upload_image = $request['upload_image'];
        $expensefile->upload_pdf = $request['upload_pdf'];
        $expense->save();

        return redirect()->route('expense.index');

        // return view('expense::index')->with('success', 'Expense has been created successfully!');
    }
}
