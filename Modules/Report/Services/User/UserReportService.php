<?php

namespace Modules\Report\Services\User;

use Modules\Project\Entities\ProjectTeamMemberEffort;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectTeamMember;

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
        $projectsId = $user->projectTeamMembers->pluck('project_id');

        $reportFteData = $this->getMonthsFteAttribute($projectsId, $user);


        return  $reportFteData;
    }

    public function getMonthsFteAttribute($projectsId, $user)
    {
        $months = [];
        $projectData = [];
        $data = [];

        foreach ($projectsId as $projectId) {
            $projectTeamMembersId = ProjectTeamMember::where('project_id', $projectId)->where('team_member_id', $user->id)->get('id');
            $startMonth = today()->subMonthsNoOverflow(17);
            $endMonth = today();
            $projectBookedHours = [];
            $index = 0;

            while ($startMonth <= $endMonth) {
                $months[$index] = $startMonth->format('Y-m');

                $teamMemberActualEffort = ProjectTeamMemberEffort::whereIn('project_team_member_id', $projectTeamMembersId)->whereMonth('added_on', $startMonth)->whereYear('added_on', $startMonth)->sum('actual_effort');

                $monthStartDate = $startMonth->copy()->firstOfMonth();
                $monthEndDate = $startMonth->copy()->lastOfMonth();
                if ($startMonth == $endMonth) {
                    $monthEndDate = today()->subDay();
                }
                $project = new Project;
                $workingDaysInAMonth = count($project->getWorkingDaysList($monthStartDate, $monthEndDate));
                if ($workingDaysInAMonth > 0) {
                    $monthlyFte = round(($teamMemberActualEffort) / ($workingDaysInAMonth * config('efforttracking.minimum_expected_hours')), 2);
                } else {
                    $monthlyFte = 0;
                }

                $projectBookedHours[] = $teamMemberActualEffort;
                $data[$index] = isset($data[$index]) ? $data[$index] + $monthlyFte : $monthlyFte;
                $index++;

                $startMonth->addMonth();
            }
            $projectName = Project::where('id', $projectId)->value('name');
            $projectData[$projectName] = [
                'projectBookedHours' => $projectBookedHours,
            ];
        }

        return [
            'labels' => $months,
            'data' => $data,
            'projectData'  => $projectData,
        ];
    }
}
