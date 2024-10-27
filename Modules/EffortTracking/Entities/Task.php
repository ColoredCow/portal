<?php
namespace Modules\EffortTracking\Entities;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'type', 'estimated_effort', 'effort_spent', 'worked_on', 'asignee_id', 'comment', 'project_id'];
}
