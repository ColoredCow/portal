<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectBillingDetail extends Model
{
    protected $fillable = ['project_id', 'service_rates', 'service_rate_term', 'currency', 'billing_frequency', 'billing_level'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
