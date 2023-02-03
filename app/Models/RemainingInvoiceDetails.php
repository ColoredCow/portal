<?php

namespace App\Models;

use App\Models\Finance\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemainingInvoiceDetails extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'amount_paid_till_now', 'last_amount_paid_on'];

}
