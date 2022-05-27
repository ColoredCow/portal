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

    public function user()
    {
        return $this->belongsTo(User::class, 'team_member_id', 'id');
    }

    public function projectTeamMemberEffort()
    {
        return $this->hasMany(ProjectTeamMemberEffort::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('ended_on');
    }

    public function getCurrentActualEffortAttribute()
    {
        return $this->projectTeamMemberEffort()->where('added_on', '>=', now(config('constants.timezone.indian'))->startOfMonth())->sum('actual_effort');
    }
    
    public function getCurrentExpectedEffortAttribute()
    {
        $project = new Project;
        $daysTillToday = count($project->getWorkingDaysList(now(config('constants.timezone.indian'))->startOfMonth(), today(config('constants.timezone.indian'))));
        return $this->daily_expected_effort * $daysTillToday;
    }

    public function getCurrentFteAttribute() 
    {
        return $this->current_expected_effort ? round($this->current_actual_effort / $this->current_expected_effort, 2) : 0;
    }
}
