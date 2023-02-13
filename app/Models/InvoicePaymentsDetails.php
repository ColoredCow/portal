<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePaymentsDetails extends Model implements Auditable
{
    use Encryptable, SoftDeletes, \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['invoice_id', 'amount_paid_till_now', 'bank_charges', 'gst', 'conversion_rate', 'conversion_rate_diff', 'comments', 'last_amount_paid_on'];

    protected $encryptable = ['amount_paid_till_now', 'tds', 'gst', 'bank_charges', 'conversion_rate', 'conversion_rate_diff'];  
}
