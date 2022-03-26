<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectContract extends Model
{
    protected $fillable = ['project_id', 'contract_file_path'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
