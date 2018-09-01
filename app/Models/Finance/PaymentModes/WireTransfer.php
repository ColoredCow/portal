<?php

namespace App\Models\Finance\PaymentModes;

use App\Models\Finance\Payment;
use Illuminate\Database\Eloquent\Model;

class WireTransfer extends Model
{
    protected $fillable = ['via'];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'mode');
    }
}
