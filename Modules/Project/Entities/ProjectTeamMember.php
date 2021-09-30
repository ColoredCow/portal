<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Project\Database\Factories\ProjectTeamMemberFactory;
use Modules\User\Entities\User;

class ProjectTeamMember extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return new ProjectTeamMemberFactory();
    }

    public function getMemberEffort()
    {
        return $this->hasMany(ProjectTeamMemberEffort::class);
    }

    public function getUserDetails()
    {
        return $this->belongsTo(User::class, 'team_member_id', 'id');
    }
}
