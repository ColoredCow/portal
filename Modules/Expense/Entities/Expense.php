<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'name',
        'amount',
        'currency',
        'status',
        'paid_on',
        'category',
        'location',
        'uploaded_by',
    ];
}
