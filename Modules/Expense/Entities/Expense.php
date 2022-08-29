<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expense';
    
    protected $guarded = [];

    protected $fillable = [
        'name',
        'amount',
        'status',
        'paid_on',
        'category',
        'location',
        'uploaded_by',
    ];
}
