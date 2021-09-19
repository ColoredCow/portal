<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class ProjectTeamMember extends Model
{
    protected $guarded = [];
    public function getMemberEffort()
    {
        return $this->hasMany(ProjectTeamMemberEffort::class);
    }

    public function getUserDetails()
    {
        return $this->belongsTo(User::class, 'team_member_id', 'id');
    }
}
