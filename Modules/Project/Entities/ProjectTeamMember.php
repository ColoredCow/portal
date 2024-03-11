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

    public function getCurrentActualEffortAttribute($startDate = null)
    {
        $startDate = $startDate ?? $this->project->client->month_start_date;

        return $this->projectTeamMemberEffort()->where('added_on', '>=', $startDate)->sum('actual_effort');
    }

    public function getCurrentExpectedEffortAttribute($startDate = null)
    {
        $project = new Project;
        $currentDate = today(config('constants.timezone.indian'));
        if ($this->started_on && $this->started_on > $this->project->client->month_start_date) {
            $startDate = $this->started_on;
        } else {
            $startDate = $this->project->client->month_start_date;
        }
        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        $daysTillToday = count($project->getWorkingDaysList($startDate, $currentDate));

        return $this->daily_expected_effort * $daysTillToday;
    }

    public function getExpectedEffortTillTodayAttribute($startDate = null)
    {
        $project = new Project;
        $startDate = $startDate ?? $this->project->client->month_start_date;
        $daysTillToday = count($project->getWorkingDaysList($this->project->client->month_start_date, today(config('constants.timezone.indian'))));

        return $this->daily_expected_effort * $daysTillToday;
    }

    public function getVelocityAttribute()
    {
        return $this->current_expected_effort ? round($this->current_actual_effort / $this->current_expected_effort, 2) : 0;
    }

    // TO DO: Need to rename this function as getCurrentFteAttribute()
    public function getFteAttribute()
    {
        $project = new Project;
        $currentDate = today(config('constants.timezone.indian'));
        $firstDayOfMonth = date('Y-m-01');

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        $daysTillToday = count($project->getWorkingDaysList($firstDayOfMonth, $currentDate));
        if ($daysTillToday == 0) {
            return 0;
        }

        return round($this->getCurrentActualEffortAttribute($firstDayOfMonth) / ($daysTillToday * config('efforttracking.minimum_expected_hours')), 2);
    }

    public function getTotalFteAttribute()
    {
        $startDate = $this->started_on;
        $endDate = $this->ended_on ?? today(config('constants.timezone.indian'));

        return $this->getFte($startDate, $endDate);
    }

    public function getTotalHoursAttribute()
    {
        $startDate = $this->started_on;
        $endDate = $this->ended_on ?? today(config('constants.timezone.indian'));

        return $this->projectTeamMemberEffort->where('added_on', '>=', $startDate)->where('added_on', '<=', $endDate)->sum('actual_effort');
    }

    public function getBorderColorClassAttribute()
    {
        if ($this->current_expected_effort == 0 && $this->current_actual_effort == 0) {
            return '';
        }

        return $this->current_actual_effort >= $this->current_expected_effort ? 'border border-success' : 'border border-danger';
    }

    public function getFte($startDate, $endDate)
    {
        $project = new Project;

        $workingDays = count($project->getWorkingDaysList($startDate, $endDate));
        $requiredEffort = $workingDays * config('efforttracking.minimum_expected_hours');
        $actualEffort = $this->getActualEffortBetween($startDate, $endDate);

        if ($requiredEffort == 0) {
            return 0;
        }

        return round($actualEffort / $requiredEffort, 2);
    }

    public function getCommittedEfforts($startDate, $endDate)
    {
        $totalWorkingDays = count($this->project->getWorkingDaysList($startDate, $endDate));

        return $this->daily_expected_effort * $totalWorkingDays;
    }

    public function getActualEffortBetween($startDate, $endDate)
    {
        return $this->projectTeamMemberEffort()
            ->where('added_on', '>=', $startDate)
            ->where('added_on', '<=', $endDate)
            ->sum('actual_effort');
    }

    protected static function newFactory()
    {
        return new ProjectTeamMemberFactory();
    }
}
