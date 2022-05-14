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

    public function getFteAttribute()
    {
        $effortTracking = new EffortTrackingService;
        $teamMembers = $this->getTeamMembers()->get();
        $teamMembersDetails = $effortTracking->getTeamMembersDetails($teamMembers);
        $totalEffort = $effortTracking->getTotalEffort($teamMembersDetails);
        $monthlyEstimatedHours = $this->monthly_estimated_hours;
        $updateDateCountAfterCount = '18:00:00';
        $currentDate = Carbon::now(config('constants.timezone.indian'));

        if (Carbon::now(config('constants.timezone.indian'))->format('H:i:s') < $updateDateCountAfterCount) {
            $currentDate = Carbon::now(config('constants.timezone.indian'))->subDay();
        }

        $totalWorkingDaysInMonth = count($this->getWorkingDaysList(now()->startOfMonth(), now()->endOfMonth()));
        $daysTillToday = count($this->getWorkingDaysList(now()->startOfMonth(), $currentDate));
        $currentExpectedEffort = ($monthlyEstimatedHours / $totalWorkingDaysInMonth) * $daysTillToday;

        return $monthlyEstimatedHours ? round($totalEffort / $currentExpectedEffort, 2) : 0;
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
}
