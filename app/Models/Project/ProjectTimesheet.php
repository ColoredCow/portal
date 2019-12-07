<?php

namespace App\Models\Project;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProjectTimesheet extends Model
{
    protected $table = 'project_timesheets';
    protected $fillable = ['project_id', 'start_date', 'end_date', 'estimated_hours'];
    protected $dates = ['start_date', 'end_date'];

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString('Y-m-d');
    }
}
