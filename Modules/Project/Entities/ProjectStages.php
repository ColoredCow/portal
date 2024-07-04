<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectStages extends Model
{
    protected $table = 'project_old_stages';
    protected $guarded = [];
    protected $fillables = ['project_id', 'stage_name', 'status', 'created_at', 'updated_at', 'end_date', 'comments'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
