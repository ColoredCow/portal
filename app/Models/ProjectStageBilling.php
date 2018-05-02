<?php

namespace App\Models;

use App\Models\Finance\Invoice;
use Illuminate\Database\Eloquent\Model;

class ProjectStageBilling extends Model
{
    protected $guarded = [];

    /**
     * Get the projectStage that has the billing.
     */
    public function projectStage()
    {
        return $this->belongsTo(ProjectStage::class);
    }

    public function invoice()
    {
    	return $this->belongsTo(Invoice::class, 'finance_invoice_id');
    }
}
