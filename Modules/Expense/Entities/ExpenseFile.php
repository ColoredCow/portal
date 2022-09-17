<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseFile extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'expense_id',
        'file_path',
        'file_type',
    ];
}
