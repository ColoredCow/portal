<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseFiles extends Model
{
    protected $table = 'expense_files';
    
    protected $guarded = [];

    protected $fillable = [
        'expense_id',
        'upload_image',
        'upload_pdf',
    ];
}
