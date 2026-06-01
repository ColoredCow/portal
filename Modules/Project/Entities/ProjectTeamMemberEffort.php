<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Project\Database\Factories\ProjectTeamMemberEffortFactory;

class ProjectTeamMemberEffort extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'project_team_members_effort';

    public function projectTeamMember()
    {
        return $this->belongsTo(ProjectTeamMember::class);
    }

    protected static function newFactory()
    {
        return new ProjectTeamMemberEffortFactory();
    }
}
