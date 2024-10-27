<?php
namespace Modules\Project\Entities;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectResourceRequirement extends Model
{
    protected $fillable = ['project_id', 'designation', 'total_requirement'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
