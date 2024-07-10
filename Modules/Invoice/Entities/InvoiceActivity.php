<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;

class InvoiceActivity extends Model
{
    protected $table = 'invoice_activities';

    protected $fillable = ['invoice_id', 'type', 'subject', 'content', 'to', 'from', 'receiver_name', 'cc', 'bcc', 'created_at', 'updated_at'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
