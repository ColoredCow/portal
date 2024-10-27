<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectTeamMemberEffort extends Model
{
    protected $guarded = [];
    protected $table = 'project_team_members_effort';

    public function projectTeamMember()
    {
        return $this->belongsTo(ProjectTeamMember::class);
    }
}
