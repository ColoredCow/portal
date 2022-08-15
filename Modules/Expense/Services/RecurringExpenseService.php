<?php

namespace Modules\Expense\Services;

use Modules\Expense\Entities\RecurringExpense;

class RecurringExpenseService
{
    public function index(array $data = [])
    {
        return RecurringExpense::query()
        ->paginate(config('constants.pagination_size'));
    }

    public function store(array $data)
    {
        $recurringExpense = RecurringExpense::create($data);
        $this->createNewExpense($recurringExpense);

        return $recurringExpense;
    }

    public function edit(int $id)
    {
        return RecurringExpense::find($id);
    }

    public function update(int $id, array $data)
    {
        $recurringExpense = RecurringExpense::find($id);
        $recurringExpense->update($data);

        return $recurringExpense;
    }

    public function destroy(int $id)
    {
        $recurringExpense = RecurringExpense::find($id);
        $recurringExpense->delete();

        return $recurringExpense;
    }

    public function createNewExpense(RecurringExpense $recurringExpense)
    {
        // ToDo:: We will create the next expense entry for this one.
        return [];
    }
}
