<?php

namespace Modules\Project\Entities;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Project\Database\Factories\ProjectTeamMemberFactory;
use Modules\User\Entities\User;
use Illuminate\Support\Carbon;

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

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
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
        $currentDate = today(config('constants.timezone.indian'));

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        $daysTillToday = count($project->getWorkingDaysList(today(config('constants.timezone.indian'))->startOfMonth(), $currentDate));

        return $this->daily_expected_effort * $daysTillToday;
    }

    public function getExpectedEffortTillTodayAttribute()
    {
        $project = new Project;
        $daysTillToday = count($project->getWorkingDaysList(today(config('constants.timezone.indian'))->startOfMonth(), today(config('constants.timezone.indian'))));

        return $this->daily_expected_effort * $daysTillToday;
    }

    public function getVelocityAttribute()
    {
        return $this->current_expected_effort ? round($this->current_actual_effort / $this->current_expected_effort, 2) : 0;
    }

    public function getFteAttribute()
    {
        $project = new Project;
        $currentDate = today(config('constants.timezone.indian'));

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        $daysTillToday = count($project->getWorkingDaysList(today(config('constants.timezone.indian'))->startOfMonth(), $currentDate));

        return round($this->current_actual_effort / ($daysTillToday * config('efforttracking.minimum_expected_hours')), 2);
    }
}
