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
        foreach ($data['documents'] as $file) {
            $documentFile = $file['file'];
            $path = 'app/public/expenseDocument';
            $imageName = $documentFile->getClientOriginalName();
            $fullpath = $documentFile->move(storage_path($path), $imageName);
            $expense = Expense::create($data);

            $expenseFile = ExpenseFile::create([
                'expense_id' => $expense->id,
                'user_id' => auth()->user()->id,
                'file_path' => $fullpath,
                'file_type' => $file['type']
            ]);
        }
    }

    public function edit(int $id)
    {
        return ExpenseFile::find($id);
    }
}
