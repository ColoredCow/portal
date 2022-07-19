<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
