<?php

namespace Modules\Project\Entities;

use App\Traits\Filters;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;
use Modules\EffortTracking\Entities\Task;
use Modules\Project\Database\Factories\ProjectFactory;
use Modules\User\Entities\User;
use Modules\EffortTracking\Services\EffortTrackingService;

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
        $effortTracking = new EffortTrackingService;
        $teamMembers = $this->getTeamMembers()->get();
        $teamMembersDetails = $effortTracking->getTeamMembersDetails($teamMembers);
        return $effortTracking->getTotalEffort($teamMembersDetails);
    }

    public function getFteAttribute()
    {
        return $this->current_expected_hours ? round($this->current_hours_for_month/$this->current_expected_hours, 2) : 0;
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

    public function getCurrentExpectedHoursAttribute() {
        $teamMembers = $this->getTeamMembers()->get();
        $updateDateCountAfterTime = config('efforttracking.update_date_count_after_time');
        $currentDate = Carbon::now(config('constants.timezone.indian'));

        if (Carbon::now(config('constants.timezone.indian'))->format('H:i:s') < $updateDateCountAfterTime) {
            $currentDate = Carbon::now(config('constants.timezone.indian'))->subDay();
        }

        $daysTillToday = count($this->getWorkingDaysList(now()->startOfMonth(), $currentDate));
        
        $currentExpectedEffort = 0;

        foreach($teamMembers as $teamMember) {
            $currentExpectedEffort += $teamMember->daily_expected_effort * $daysTillToday;
        }

        return round($currentExpectedEffort, 2);
    }

    public function getExpectedMonthlyHoursAttribute() {
        $teamMembers = $this->getTeamMembers()->get();
        $effortTracking = new EffortTrackingService;
        $workingDaysCount = count($effortTracking->getWorkingDays(now()->startOfMonth(), now()->endOfMonth()));
        $expectedMonthlyHours = 0;

        foreach ($teamMembers as $teamMember) {
            $expectedMonthlyHours += $teamMember->daily_expected_effort * $workingDaysCount;
        }

        return round($expectedMonthlyHours, 2);
    }
}
