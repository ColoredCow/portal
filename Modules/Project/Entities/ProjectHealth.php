<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectHealth extends Model
{
    protected $guarded = [];
    protected $table = 'project_health';

    public function ProjectHealthDetails()
    {
        return $this->belongsTo(Project::class);
    }
}
