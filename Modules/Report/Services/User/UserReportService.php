<?php

namespace Modules\Report\Services\User;

use Modules\Project\Entities\ProjectTeamMemberEffort;
use Modules\Project\Entities\Project;

class UserReportService
{
    protected $service;

    public function getFteData($type, $user)
    {
        if ($type == 'fte-trend') {
            return $this->fteTrend($user);
        }
    }

    public function fteTrend($user)
    {
        $projectTeamMemberList = $user->projectTeamMembers->pluck('id');
        $reportFteData = $this->getMonthsFteAttribute($projectTeamMemberList);

        return  $reportFteData;
    }

    public function getMonthsFteAttribute($projectTeamMemberList)
    {
        $startMonth = today()->subMonthsNoOverflow(17);
        $endMonth = today();
        $months = [];
        $data = [];
        while ($startMonth <= $endMonth) {
            $months[] = $startMonth->format('Y-m');
            $teamMemberActualEffort = ProjectTeamMemberEffort::whereIn('project_team_member_id', $projectTeamMemberList)->whereMonth('added_on', $startMonth)->whereYear('added_on', $startMonth)->sum('actual_effort');

            $monthStartDate = $startMonth->copy()->firstOfMonth();
            $monthEndDate = $startMonth->copy()->lastOfMonth();
            if ($startMonth == $endMonth) {
                $monthEndDate = today();
            }
            $project = new Project;
            $workingDaysInAMonth = count($project->getWorkingDaysList($monthStartDate, $monthEndDate));
            if ($workingDaysInAMonth > 0) {
                $monthlyFte = round($teamMemberActualEffort / ($workingDaysInAMonth * config('efforttracking.minimum_expected_hours')), 2);
            } else {
                $monthlyFte = 0;
            }
            $data[] = $monthlyFte;
            $startMonth->addMonth();
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }
}
