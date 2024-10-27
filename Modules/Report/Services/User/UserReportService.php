<?php
namespace Modules\Report\Services\User;

use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMemberEffort;

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
        $projectsId = $user->projectTeamMembers()->distinct('project_id')->pluck('project_id');

        return $this->getMonthsFteAttribute($projectsId, $user);
    }

    public function getMonthsFteAttribute($projectIds, $user)
    {
        $months = [];
        $projectData = [];
        $fteData = [];
        $startMonth = today()->subMonthsNoOverflow(17);
        $endMonth = today();
        $index = 0;

        while ($startMonth <= $endMonth) {
            $monthStartDate = $startMonth->copy()->firstOfMonth();
            $monthEndDate = $startMonth->copy()->lastOfMonth();
            if ($startMonth == $endMonth) {
                $monthEndDate = today()->subDay();
            }
            $months[$index] = $monthStartDate->format('Y-m');
            $project = new Project;
            $workingDaysInAMonth = count($project->getWorkingDaysList($monthStartDate, $monthEndDate));
            $totalEffortInMonth = 0;

            foreach ($projectIds as $projectId) {
                $projectTeamMemberIds = ProjectTeamMember::where('project_id', $projectId)->where('team_member_id', $user->id)->get('id');
                $teamMemberActualEffort = ProjectTeamMemberEffort::whereIn('project_team_member_id', $projectTeamMemberIds)->whereMonth('added_on', $monthStartDate)->whereYear('added_on', $monthStartDate)->sum('actual_effort');
                $projectName = Project::where('id', $projectId)->value('name');
                $projectData[$projectName]['projectBookedHours'][$index] = $teamMemberActualEffort;
                $totalEffortInMonth += $teamMemberActualEffort;
            }

            if ($workingDaysInAMonth > 0) {
                $monthlyFte = round($totalEffortInMonth / ($workingDaysInAMonth * config('efforttracking.minimum_expected_hours')), 2);
            } else {
                $monthlyFte = 0;
            }
            $fteData[$index] = isset($fteData[$index]) ? $fteData[$index] + $monthlyFte : $monthlyFte;
            $index++;
            $startMonth->addMonth();
        }

        return [
            'labels' => $months,
            'data' => $fteData,
            'projectData'  => $projectData,
        ];
    }
}
