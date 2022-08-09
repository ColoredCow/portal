<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;

class InvoiceAudit extends Model
{
    protected $fillable = [];
    protected $table = 'invoice_audit';
}
