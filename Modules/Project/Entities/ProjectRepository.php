<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Project\Entities\Project;

class ProjectRepository extends Model
{

    protected $guarded = array();

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
