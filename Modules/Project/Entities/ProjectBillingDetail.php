<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectBillingDetail extends Model
{
    protected $fillable = ['project_id', 'service_rates', 'service_rate_term', 'currency'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
