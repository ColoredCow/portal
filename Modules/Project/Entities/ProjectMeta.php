<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Google\Service\RecaptchaEnterprise\Resource\ProjectsKeys;

class ProjectMeta extends Model
{
    protected $table = 'project_meta';
    protected $guarded = [];

    public function meta()
    {
        return $this->belongsTo(Projects::class);
    }
}
