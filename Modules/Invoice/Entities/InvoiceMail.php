<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Invoice\Entities\Invoice;

class InvoiceMail extends Model
{
    use HasFactory;
    protected $table = 'invoice_mails';
    protected $guarded = [];
  
    public function Invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
