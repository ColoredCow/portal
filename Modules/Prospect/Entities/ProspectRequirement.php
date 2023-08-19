<?php

namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;

class ProspectRequirement extends Model
{
    protected $fillable = ['prospect_id', 'project_brief', 'skills', 'resource_required_count', 'excepted_launch_date', 'notes'];
    protected $casts = [
        'skills' => 'array',
        'excepted_launch_date' => 'date:Y-m-d',
    ];
}
