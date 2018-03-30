<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'finance_invoices';

    protected $fillable = ['name', 'project_id', 'review_value', 'status', 'sent_on', 'sent_to', 'paid_on', 'file_path'];

}
