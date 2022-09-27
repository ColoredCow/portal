<?php

namespace Modules\Expense\Services;

use Modules\Expense\Entities\Expense;
use Modules\Expense\Entities\ExpenseFile;

class ExpenseService
{
    public function index(array $data = [])
    {
        return Expense::query()
        ->paginate(config('constants.pagination_size'));
    }

    public function store(array $data)
    {
        $expense = Expense::create($data);

        foreach ($data['documents'] as $file) {
            $documentFile = $file['file'];
            $path = 'app/public/expenseDocument';
            $imageName = $documentFile->getClientOriginalName();
            $fullpath = $documentFile->move(storage_path($path), $imageName);
            ExpenseFile::create([
                'expense_id' => $expense->id,
                'user_id' => auth()->user()->id,
                'file_path' => $fullpath,
                'file_type' => $file['type']
            ]);
        }
    }

    public function edit(int $id)
    {
        $expense = Expense::where('id', $id)->get();
        $expenseFile = ExpenseFile::where('expense_id', $id)->get();

        return compact('expense','expenseFile');
    }

    public function update( $data, $id)
    {
        Expense::find($id)->update($data);
        
        foreach ($data['documents'] as $key => $file) {
            ExpenseFile::find($key)->update($data);
            $documentFile = $file['file'];
            $path = 'app/public/expenseDocument';
            $imageName = $documentFile->getClientOriginalName();
            $fullpath = $documentFile->move(storage_path($path), $imageName);
            ExpenseFile::where('id', $key)->update([
                'file_path' => $fullpath,
                'file_type' => $file['type']
            ]);
        }
    }

    public function delete($id)
    {
        Expense::find($id)->delete($id);
        ExpenseFile::where('expense_id', $id)->delete($id);
    }
}
