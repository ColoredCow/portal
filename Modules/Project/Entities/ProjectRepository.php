<?php
namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectRepository extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
