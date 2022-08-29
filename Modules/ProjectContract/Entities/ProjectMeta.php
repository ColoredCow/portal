<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectMeta extends Model
{
    protected $table = 'project_meta';
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
