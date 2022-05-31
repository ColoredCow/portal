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
        $currentDate = Carbon::now(config('constants.timezone.indian'));

        if (Carbon::now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = Carbon::now(config('constants.timezone.indian'))->subDay();
        }

        $totalEffort = $project->current_hours_for_month;
        $workingDays = $this->getWorkingDays(now()->startOfMonth(), $currentDate);
        $startDate = Carbon::now(config('constants.timezone.indian'))->startOfMonth();
        $endDate = Carbon::now(config('constants.timezone.indian'))->endOfMonth();
        $totalWorkingDays = count($this->getWorkingDays($startDate, $endDate));

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

    /**
     * Calculate FTE.
     * @param  int $currentHours  Current Hours.
     * @param  int $expectedHours Expected Hours.
     * @return float              FTE
     */
    public function getFTE($currentHours, $expectedHours)
    {
        if ($expectedHours == 0) {
            return 0;
        }

        return round($currentHours / $expectedHours, 2);
    }

    /**
     * Get expected hours.
     * @param  int $numberOfDays Number of days.
     * @param float $expectedDailyHours Expected daily hours.
     * @return int|float         Expected hours.
     */
    public function getExpectedHours($expectedDailyHours, $numberOfDays)
    {
        return $expectedDailyHours * $numberOfDays;
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
        $currentDate = now(config('constants.timezone.indian'));
        $startDate = $currentDate->startOfMonth()->toDateString();
        $endDate = $currentDate->endOfMonth()->toDateString();

        foreach ($teamMembers as $teamMember) {
            $userDetails = $teamMember->user;
            $efforts = $teamMember->projectTeamMemberEffort()->get();

            if (! $userDetails) {
                continue;
            }

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

            if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
                $currentDate = now(config('constants.timezone.indian'))->subDay();
            }

            $teamMembersEffortUserDetails = $efforts->isNotEmpty() ? end($teamMembersEffort[$userDetails->id]) : [];
            $totalEffortInEffortsheet = array_key_exists('total_effort_in_effortsheet', $teamMembersEffortUserDetails) ? $teamMembersEffortUserDetails['total_effort_in_effortsheet'] : 0;
            $expectedEffort = $this->getExpectedHours($teamMember->daily_expected_effort, count($this->getWorkingDays(now()->startOfMonth(), $currentDate)));
            $users[] = [
                'id' => $userDetails->id,
                'name' => $userDetails->name,
                'actual_effort' => $totalEffortInEffortsheet,
                'expected_effort' => $expectedEffort,
                'FTE' => $this->getFTE($totalEffortInEffortsheet, $expectedEffort),
            ];
        }

        return [
            'teamMembersEffort' => empty($teamMembersEffort) ? 0 : $teamMembersEffort,
            'users' => $users,
        ];
    }
}
