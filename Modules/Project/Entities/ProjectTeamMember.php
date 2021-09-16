<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Project\Database\Factories\ProjectTeamMemberFactory;

class ProjectTeamMember extends Model
{
    protected $guarded = [];

    protected static function factory()
    {
        return ProjectTeamMemberFactory::new();
    }
}
