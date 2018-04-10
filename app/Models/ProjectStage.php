<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStage extends Model
{
	protected $table = 'project_stages';

    protected $fillable = ['project_id', 'name', 'cost', 'currency_cost', 'cost_include_gst'];
}
