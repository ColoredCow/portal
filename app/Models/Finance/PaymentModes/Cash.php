<?php
namespace App\Models\Finance\PaymentModes;

use App\Models\Finance\Payment;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table = 'cash';

    protected $fillable = [];

    protected $appends = ['type'];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'mode');
    }

    public function getTypeAttribute()
    {
        return 'cash';
    }
}
