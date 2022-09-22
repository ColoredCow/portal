<?php

namespace Modules\Expense\Services;

use Modules\Expense\Entities\Expense;

class ExpenseService
{
    public function index(array $data = [])
    {
        return Expense::query()
        ->paginate(config('constants.pagination_size'));
    }

    public function store(array $data)
    {
        return Expense::create($data);
    }

    public function edit(int $id)
    {
        return Expense::find($id);
    }
}
