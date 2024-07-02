<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectInvoiceTerm extends Model
{
    protected $fillable = ['project_id', 'invoice_date', 'status', 'client_acceptance_required', 'amount', 'is_accepted', 'report_required', 'delivery_report'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
