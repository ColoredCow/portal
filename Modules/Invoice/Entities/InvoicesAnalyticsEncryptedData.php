<?php

namespace App\Models\Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesAnalyticsEncryptedData extends Model
{
    use HasFactory;

    protected $table = 'invoices_analytics_encrypted_data';
    protected $fillable = [
        'invoice_id', 'amount', 'gst', 'amount_paid', 'bank_charges',
        'conversion_rate_diff', 'tds', 'sent_conversion_rate',
    ];
}
