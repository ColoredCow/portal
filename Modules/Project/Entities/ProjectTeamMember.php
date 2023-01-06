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

    protected $dates = [
        'started_on',
        'ended_on',
        'created_at',
        'updated_at',
    ];

    protected static function newFactory()
    {
        return new ProjectTeamMemberFactory();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'team_member_id', 'id')->withTrashed();
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
        return $this->projectTeamMemberEffort()->where('added_on', '>=', $this->project->client->month_start_date)->sum('actual_effort');
    }

    public function getCurrentExpectedEffortAttribute()
    {
        $project = new Project;
        $currentDate = today(config('constants.timezone.indian'));

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        $daysTillToday = count($project->getWorkingDaysList($this->project->client->month_start_date, $currentDate));

        return $this->daily_expected_effort * $daysTillToday;
    }

    public function getExpectedEffortTillTodayAttribute()
    {
        $project = new Project;
        $daysTillToday = count($project->getWorkingDaysList($this->project->client->month_start_date, today(config('constants.timezone.indian'))));

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

        $daysTillToday = count($project->getWorkingDaysList($this->project->client->month_start_date, $currentDate));
        if ($daysTillToday == 0) {
            return 0;
        }

        return round($this->current_actual_effort / ($daysTillToday * config('efforttracking.minimum_expected_hours')), 2);
    }

    public function getBorderColorClassAttribute()
    {
        if ($this->current_expected_effort == 0 && $this->current_actual_effort == 0) {
            return '';
        }

        return $this->current_actual_effort >= $this->current_expected_effort ? 'border border-success' : 'border border-danger';
    }
}
