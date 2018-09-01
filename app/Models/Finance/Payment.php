<?php

namespace App\Models\Finance;

use App\Models\Finance\Invoice;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function mode()
    {
        return $this->morphTo();
    }
}
