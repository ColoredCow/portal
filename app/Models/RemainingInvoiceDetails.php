<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemainingInvoiceDetails extends Model implements Auditable
{
    use Encryptable, SoftDeletes, \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['invoice_id', 'amount_paid_till_now', 'last_amount_paid_on'];

    protected $encryptable = [
         'amount_paid_till_now',
    ];
   
}
