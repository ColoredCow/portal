<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Invoice\Entities\Invoice;

class ProjectInvoiceTerm extends Model
{
    protected $fillable = ['project_id', 'invoice_date', 'status', 'confirmation_required', 'amount', 'is_confirmed', 'delivery_report'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
