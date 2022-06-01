<?php

namespace Modules\Project\Entities;

use App\Traits\Filters;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;
use Modules\EffortTracking\Entities\Task;
use Modules\Project\Database\Factories\ProjectFactory;
use Modules\User\Entities\User;

class Project extends Model
{
    use HasFactory, Filters;

    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

    protected static function newFactory()
    {
        return new ProjectFactory();
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'project_team_members', 'project_id', 'team_member_id')
            ->withPivot('designation', 'ended_on', 'id', 'daily_expected_effort')->withTimestamps()->whereNull('project_team_members.ended_on');
    }

    public function repositories()
    {
        return $this->hasMany(ProjectRepository::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getTeamMembers()
    {
        return $this->hasMany(ProjectTeamMember::class)->whereNULL('ended_on');
    }

    public function projectContracts()
    {
        return $this->hasMany(ProjectContract::class);
    }

    public function getCurrentHoursForMonthAttribute()
    {
        $teamMembers = $this->getTeamMembers()->get();
        $totalEffort = 0;

        foreach ($teamMembers as $teamMember) {
            $totalEffort += $teamMember->projectTeamMemberEffort->whereBetween('added_on', [now(config('constants.timezone.indian'))->startOfMonth()->subDay(), now(config('constants.timezone.indian'))->endOfMonth()->addDay()])->sum('actual_effort');
        }

        return $totalEffort;
    }

    public function getFteAttribute()
    {
        return $this->current_expected_hours ? round($this->current_hours_for_month / $this->current_expected_hours, 2) : 0;
    }

    public function getWorkingDaysList($startDate, $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = [];
        $weekend = ['Saturday', 'Sunday'];
        foreach ($period as $date) {
            if (! in_array($date->format('l'), $weekend)) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return $dates;
    }

    public function getCurrentExpectedHoursAttribute()
    {
        $teamMembers = $this->getTeamMembers()->get();
        $currentDate = today(config('constants.timezone.indian'));
        $daysTillToday = count($this->getWorkingDaysList(today(config('constants.timezone.indian'))->startOfMonth(), $currentDate));
        $currentExpectedEffort = 0;

        foreach ($teamMembers as $teamMember) {
            $currentExpectedEffort += $teamMember->daily_expected_effort * $daysTillToday;
        }

        return round($currentExpectedEffort, 2);
    }

    public function getExpectedMonthlyHoursAttribute()
    {
        $teamMembers = $this->getTeamMembers()->get();
        $workingDaysCount = count($this->getWorkingDaysList(now(config('constants.timezone.indian'))->startOfMonth(), now(config('constants.timezone.indian'))->endOfMonth()));
        $expectedMonthlyHours = 0;

        foreach ($teamMembers as $teamMember) {
            $expectedMonthlyHours += $teamMember->daily_expected_effort * $workingDaysCount;
        }

        return round($expectedMonthlyHours, 2);
    }
}
