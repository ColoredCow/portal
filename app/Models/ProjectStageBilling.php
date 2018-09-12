<?php

namespace App\Models;

use App\Models\Finance\Invoice;
use Illuminate\Database\Eloquent\Model;

class ProjectStageBilling extends Model
{
    protected $guarded = [];

    protected $appends = ['amount'];

    /**
     * Get the projectStage that has the billing.
     */
    public function projectStage()
    {
        return $this->belongsTo(ProjectStage::class);
    }

    /**
     * Get the invoice that has the billing
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getAmountAttribute()
    {
        return ($this->percentage * $this->projectStage->cost) / 100;
    }
}
