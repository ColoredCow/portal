<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectInvoiceTerm extends Model
{
    protected $fillable = [ 'project_id', 'invoice_date', 'status', 'amount'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
