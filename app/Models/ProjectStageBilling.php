<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStageBilling extends Model
{
    protected $fillable = ['project_stage_id', 'percentage'];
}
