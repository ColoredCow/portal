<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStagesListing extends Model
{
    use HasFactory;
    protected $table = 'project_stages_listing';
    protected $guarded = [];
    protected $fillables = ['name', 'created_at', 'updated_at'];
}
