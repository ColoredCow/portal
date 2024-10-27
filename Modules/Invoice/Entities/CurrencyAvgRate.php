<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;

class CurrencyAvgRate extends Model
{
    protected $table = 'currency_avg_rate';
    protected $fillable = ['currency', 'captured_for', 'avg_rate'];
    protected $casts = ['captured_for' => 'date'];
}
