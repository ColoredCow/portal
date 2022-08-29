<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectBillingDetails extends Model
{
    protected $fillable = ['project_id', 'service_rates', 'service_rate_term', 'currency'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
