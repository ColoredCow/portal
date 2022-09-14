<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Project\Database\Factories\ProjectTeamMemberFactory;
use Modules\User\Entities\User;
use Carbon\Carbon;

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
    public function getCurrentActualEffortAttribute($startDate = null)
    {
        $startDate = $startDate ?? $this->project->client->month_start_date;

        return $this->projectTeamMemberEffort()->where('added_on', '>=', $startDate)->sum('actual_effort');
    }
    public function getCurrentExpectedEffortAttribute($startDate = null, $endDate = null)
    {
        $project = new Project;
        $currentDate = today(config('constants.timezone.indian'));
        $startDate = $startDate ?? $this->project->client->month_start_date;
        $endDate = $endDate ?? $this->project->client->month_end_date;

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        $daysTillToday = count($project->getWorkingDaysList($startDate, $endDate));

        return $this->daily_expected_effort * $daysTillToday;
    }

    public function getExpectedEffortTillTodayAttribute($startDate = null, $endDate = null)
    {
        $currentMonth = Carbon::now()->format('m');
        $project = new Project;
        $currentDate = today(config('constants.timezone.indian'));
        $startDate = $startDate ?? $this->project->client->month_start_date;
        $Month = intval(date('m', strtotime($startDate)));
        $endDate = $endDate ?? $this->project->client->month_end_date;


        if ($Month == $currentMonth) {
            $daysTillToday = count($project->getWorkingDaysList($startDate, $currentDate));
        } else {
            $daysTillToday = count($project->getWorkingDaysList($startDate, $endDate));
        }

        return $this->daily_expected_effort * $daysTillToday;
    }
    public function getVelocityAttribute($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? $this->project->client->month_start_date;
        $endDate = $endDate ?? $this->project->client->month_end_date;

        return $this->getCurrentExpectedEffortAttribute($startDate = null, $endDate = null) ? round($this->getCurrentActualEffortAttribute($startDate = null) / $this->getCurrentExpectedEffortAttribute($startDate = null, $endDate = null), 2) : 0;
    }

    public function getFteAttribute($startDate = null, $endDate = null)
    {
        $currentMonth = Carbon::now()->format('m');
        $project = new Project;
        $currentDate = today(config('constants.timezone.indian'));
        $startDate = $startDate ?? $this->project->client->month_start_date;
        $Month = intval(date('m', strtotime($startDate)));
        $endDate = $endDate ?? $this->project->client->month_end_date;

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        if ($Month == $currentMonth) {
            $daysTillToday = count($project->getWorkingDaysList($startDate, $currentDate));
        } else {
            $daysTillToday = count($project->getWorkingDaysList($startDate, $endDate));
        }

        if ($daysTillToday == 0) {
            return 0;
        }
    
        return round($this->getCurrentActualEffortAttribute($startDate = null) / ($daysTillToday * config('efforttracking.minimum_expected_hours')), 2);
    }
}
