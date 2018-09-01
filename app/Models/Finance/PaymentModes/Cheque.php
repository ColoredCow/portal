<?php

namespace App\Models\Finance\PaymentModes;

use App\Models\Finance\Payment;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $fillable = ['status', 'received_on', 'cleared_on', 'bounced_on'];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'mode');
    }
}
