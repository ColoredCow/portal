<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Invoice\Entities\Invoice;

class InvoicePaymentsDetails extends Model implements Auditable
{
    use Encryptable, SoftDeletes, \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['invoice_id', 'amount_paid', 'bank_charges', 'tds', 'tds_percentage', 'conversion_rate', 'conversion_rate_diff', 'comments', 'amount_paid_on'];

    protected $encryptable = ['amount_paid', 'tds', 'tds_percentage', 'bank_charges', 'conversion_rate', 'conversion_rate_diff'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
