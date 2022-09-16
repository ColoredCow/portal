<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CurrencyAvgRates extends Model
{
    protected $table = 'currency_avg_rate';
    protected $fillable = ['currency', 'captured_for', 'avg_rate', 'created_at', 'updated_at'];
}
