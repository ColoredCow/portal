<?php

namespace App\Models\Finance;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'finance_invoices';

    protected $fillable = ['name', 'project_id', 'project_invoice_id', 'review_value', 'status', 'sent_on', 'paid_on', 'file_path'];

    /**
     * Get the project that associated with the invoice.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
