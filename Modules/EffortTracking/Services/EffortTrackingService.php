<?php

namespace Modules\EffortTracking\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EffortTrackingService
{
    public function show($project)
    {
        $teamMembers = $project->getTeamMembers()->get();
        $teamMembersDetails = $this->getTeamMembersDetails($teamMembers);
        $teamMembersEffort = [];
        $users = [];
        $totalEffort = $this->getTotalEffort($teamMembersDetails);
        $workingDays = $this->getWorkingDays(now()->startOfMonth(), now());
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        $totalWorkingDays = count($this->getWorkingDays($startDate, $endDate));
        $expectedHours = $this->getExpectedHours(count($workingDays));

        return [
            'project' => $project,
            'teamMembersEffort' => empty($teamMembersDetails['teamMembersEffort']) ? 0 : json_encode($teamMembersDetails['teamMembersEffort']),
            'users' => json_encode($teamMembersDetails['users']),
            'workingDays' => json_encode($workingDays),
            'totalWorkingDays' => $totalWorkingDays,
            'totalEffort' => $totalEffort,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentMonth' => now()->format('F'),
        ];
    }

    public function getTotalEffort($teamMembersDetails)
    {
        $totalEffort = 0;
        if (is_array($teamMembersDetails['teamMembersEffort'])) {
            foreach ($teamMembersDetails['teamMembersEffort'] as $key => $teamMemberEffort) {
                $totalTeamMemberEffort = end($teamMemberEffort)['total_effort_in_effortsheet'] ?? 0;
                $totalEffort += $totalTeamMemberEffort;
            }
        }

        return $totalEffort;
    }

    /**
     * Calculate FTE.
     * @param  int $currentHours  Current Hours.
     * @param  int $expectedHours Expected Hours.
     * @return float              FTE
     */
    public function getFTE($currentHours, $expectedHours)
    {
        if ($expectedHours === 0) {
            return 0;
        }

        return round($currentHours / $expectedHours, 2);
    }

    /**
     * Get expected hours.
     * @param  int $numberOfDays Number of days.
     * @return int|float         Expected hours.
     */
    public function getExpectedHours($numberOfDays)
    {
        return config('efforttracking.minimum_expected_hours') * $numberOfDays;
    }

    /**
     * Get working days.
     * @param  object $startDate Start Date.
     * @param  object $endDate   End Date.
     * @return array             Working Days dates.
     */
    public function getWorkingDays($startDate, $endDate)
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

    /**
     * Get Team members details.
     * @param  array $teamMembers Team Members.
     * @return array
     */
    public function getTeamMembersDetails($teamMembers)
    {
        $teamMembersEffort = [];
        $users = [];
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();
        foreach ($teamMembers as $teamMember) {
            $userDetails = $teamMember->getUserDetails;
            $efforts = $teamMember->projectTeamMemberEffort()->get();
            if ($efforts->isNotEmpty()) {
                foreach ($efforts as $effort) {
                    $effortAddedOn = new Carbon($effort->added_on);
                    $teamMembersEffort[$userDetails->id][$effort->id]['name'] = $userDetails->name;
                    if ($startDate <= $effortAddedOn && $effortAddedOn <= $endDate) {
                        $teamMembersEffort[$userDetails->id][$effort->id]['actual_effort'] = $effort->actual_effort;
                        $teamMembersEffort[$userDetails->id][$effort->id]['total_effort_in_effortsheet'] = $effort->total_effort_in_effortsheet;
                        $teamMembersEffort[$userDetails->id][$effort->id]['added_on'] = $effortAddedOn->format('Y-m-d');
                    }
                }
            }
            $teamMembersEffortUserDetails = $efforts->isNotEmpty() ? end($teamMembersEffort[$userDetails->id]) : [];
            $totalEffortInEffortsheet = array_key_exists('total_effort_in_effortsheet', $teamMembersEffortUserDetails) ? $teamMembersEffortUserDetails['total_effort_in_effortsheet'] : 0;
            $users[] = [
                'id' => $userDetails->id,
                'name' => $userDetails->name,
                'actual_effort' => $totalEffortInEffortsheet,
                'expected_effort' => $this->getExpectedHours(count($this->getWorkingDays(now()->startOfMonth(), now()))),
                'FTE' => $this->getFTE($totalEffortInEffortsheet, $this->getExpectedHours(count($this->getWorkingDays(now()->startOfMonth(), now())))),
            ];
        }

        return [
            'teamMembersEffort' => empty($teamMembersEffort) ? 0 : $teamMembersEffort,
            'users' => $users,
        ];
    }
}
