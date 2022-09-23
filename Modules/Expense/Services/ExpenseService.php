<?php

namespace Modules\Expense\Services;

use Illuminate\Http\Request;
use Modules\Expense\Entities\Expense;
use Modules\Expense\Entities\ExpenseFile;

class ExpenseService
{
    public function index(array $data = [])
    {
        return Expense::query()
        ->paginate(config('constants.pagination_size'));
    }

    public function store(Request $request)
    {
        $file = $request->file('file_path');
        $path = 'app/public/expenseDocument';
        $imageName = $file->getClientOriginalName();
        $fullpath = $file->move(storage_path($path), $imageName);

        $expense = new Expense;
        $expense->name = $request['name'];
        $expense->status = $request['status'];
        $expense->amount = $request['amount'];
        $expense->currency = $request['currency'];
        $expense->category = $request['category'];
        $expense->location = $request['location'];
        $expense->paid_at = $request['paid_at'];
        $expense->save();
        $expenseFile = new ExpenseFile;

        $expenseFile->expense_id = $expense->id;
        $expenseFile->file_type = $request['file_type'];
        $expenseFile->file_path = $fullpath;
        $expenseFile->user_id = auth()->user()->id;
        $expenseFile->save();
    }

    public function edit(int $id)
    {
        return ExpenseFile::find($id);
    }
}
