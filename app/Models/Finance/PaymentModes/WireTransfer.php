<?php

namespace App\Models\Finance\PaymentModes;

use App\Models\Finance\Payment;
use Illuminate\Database\Eloquent\Model;

class WireTransfer extends Model
{
    protected $fillable = ['via'];

    protected $appends = ['type'];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'mode');
    }

    public function getTypeAttribute()
    {
        return 'wire-transfer';
    }
}
