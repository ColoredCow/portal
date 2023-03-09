<?php

namespace Modules\Report\Services\User;

use Modules\Project\Entities\ProjectTeamMemberEffort;
use Carbon\Carbon;
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
        $startMonth = today()->subMonth(17)->format('Y-m');
        $endMonth = today()->format('Y-m');
        $projectTeamMemberId = $user->projectTeamMembers->pluck('id');
        $userFte = $this->getMonthsFteAttribute($startMonth, $endMonth, $projectTeamMemberId);

        return  $userFte;
    }

    public function getMonthsFteAttribute($startMonth, $endMonth, $projectTeamMemberId)
    {
        $data = [];
        $date = Carbon::createFromFormat('Y-m', $startMonth);
        $month = $date->format('m');
        $year = $date->format('Y');
        $endDate = Carbon::createFromFormat('Y-m', $endMonth);
        while ($date->lte($endDate)) {
            $teamMemberEffort = ProjectTeamMemberEffort::where('project_team_member_id', $projectTeamMemberId)->whereMonth('added_on', $month)->whereYear('added_on', $year)->get();
            $actualEffort = 0;
            foreach ($teamMemberEffort as $effort) {
                $actualEffort += $effort->actual_effort;
            }
            if ($teamMemberEffort->isEmpty()) {
                $startMonth = Carbon::createFromFormat('Y-m', $startMonth)->addMonth()->format('Y-m');
                $date = Carbon::createFromFormat('Y-m', $startMonth);
                $month = $date->format('m');
                $year = $date->format('Y');
                $data[] = 0;
                continue;
            }
            $monthEndDate = Carbon::parse($teamMemberEffort->last()->added_on);
            $monthStartDate = Carbon::createFromDate($year, $month, 1);
            $project = new Project;
            $daysTillToday = count($project->getWorkingDaysList($monthStartDate, $monthEndDate));
            if ($daysTillToday > 0) {
                $monthlyFte = round($actualEffort / ($daysTillToday * config('efforttracking.minimum_expected_hours')), 2);
            } else {
                $monthlyFte = 0;
            }
            $startMonth = Carbon::createFromFormat('Y-m', $startMonth)->addMonth()->format('Y-m');
            $date = Carbon::createFromFormat('Y-m', $startMonth);
            $month = $date->format('m');
            $year = $date->format('Y');
            $data[] = $monthlyFte;
        }

        return $data;
    }
}
