<?php

namespace Modules\EffortReport\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeEffort extends Model
{
    protected $fillable = [];

    protected $table = 'effort_report';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
