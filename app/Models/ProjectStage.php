<?php

namespace App\Models;

use App\Models\ProjectStageBilling;
use Illuminate\Database\Eloquent\Model;

class ProjectStage extends Model
{
    protected $table = 'project_stages';

    protected $guarded = [];

    /**
     * Get the billings for the project stage.
     */
    public function billings()
    {
        return $this->hasMany(ProjectStageBilling::class);
    }

    /**
     * Get the project that has the stage.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
