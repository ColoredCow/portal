<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'amount',
        'currency',
        'status',
        'category',
        'location',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];
}
