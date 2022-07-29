<?php

namespace Modules\EffortTracking\Services;

use Carbon\Carbon;
use Exception;
use Carbon\CarbonPeriod;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;
use Revolution\Google\Sheets\Sheets;
use Illuminate\Support\Str;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Modules\Project\Entities\ProjectMeta;

class EffortTrackingService
{
    public function show($project)
    {
        $teamMembers = $project->getTeamMembers()->get();
        $teamMembersDetails = $this->getTeamMembersDetails($teamMembers);
        $currentDate = now('');
        if (now('')->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = now('')->subDay();
        }
        $totalEffort = $project->current_hours_for_month;
        $workingDays = $this->getWorkingDays($project->client->month_start_date, $currentDate);
        $startDate = $project->client->month_start_date;
        $endDate = $project->client->client_month_end_date;
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
        $currentDate = now('');
        if (now('')->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = now('')->subDay();
        }
        if (isset($teamMembers[0])) {
            $startDate = $teamMembers[0]->project->client->month_start_date;
            $endDate = $teamMembers[0]->project->client->client_month_end_date;
        } else {
            $startDate = $currentDate->startOfMonth()->toDateString();
            $endDate = $currentDate->endOfMonth()->toDateString();
        }
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

            $teamMembersEffortUserDetails = $efforts->isNotEmpty() ? end($teamMembersEffort[$userDetails->id]) : [];
            $totalEffortInEffortsheet = array_key_exists('total_effort_in_effortsheet', $teamMembersEffortUserDetails) ? $teamMembersEffortUserDetails['total_effort_in_effortsheet'] : 0;
            $expectedEffort = $this->getExpectedHours($teamMember->daily_expected_effort, count($this->getWorkingDays($teamMember->project->client->month_start_date, $currentDate)));
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

    public function getEffortForProject($project)
    {
        $users = User::with('projectTeamMembers');
        $sheetColumnsName = config('efforttracking.columns_name');
        try {
            $effortSheetUrl = $project->effort_sheet_url ?: $project->client->effort_sheet_url;

            if (! $effortSheetUrl) {
                return false;
            }

            $correctedEffortsheetUrl = [];

            $isSyntaxMatching = preg_match('/.*[^-\w]([-\w]{25,})[^-\w]?.*/', $effortSheetUrl, $correctedEffortsheetUrl);

            if (! $isSyntaxMatching) {
                return false;
            }

            $sheetId = $correctedEffortsheetUrl[1];
            $sheets = new Sheets();
            $projectMembersCount = $project->teamMembers()->count();
            $lastColumn = config('efforttracking.default_last_column_in_effort_sheet');
            $columnIndex = 5;
            $projectsInSheet = [];

            try {
                while (true) {
                    $range = 'C1:' . ++$lastColumn . '1';
                    $sheet = $sheets->spreadsheet($sheetId)
                        ->range($range)
                        ->get();

                    if (isset($sheet[0]) && count($sheet[0]) == ++$columnIndex) {
                        $subProjectName = $sheet[0][count($sheet[0]) - 1];
                        $subProject = Project::where(['name' => $subProjectName, 'status' => 'active'])->first();
                        if ($subProject) {
                            $projectsInSheet[] = [
                                'id' => $subProject->id,
                                'name' => $subProjectName,
                                'sheetIndex' => $columnIndex - 1
                            ];
                        }
                        continue;
                    }

                    $lastColumn = chr(ord((string) $lastColumn) - 1);
                    $columnIndex--;
                    break;
                }
            } catch (Exception $e) {
                return false;
            }

            $range = config('efforttracking.default_start_column_in_effort_sheet') . '2:' . $lastColumn . ($projectMembersCount + 1); // this will depend on the number of people on the project
            $sheetIndexForTeamMemberName = $this->getColumnIndex($sheetColumnsName['team_member_name'], $sheet[0]);
            $sheetIndexForTotalBillableEffort = $this->getColumnIndex($sheetColumnsName['billable_effort'], $sheet[0]);
            $sheetIndexForStartDate = $this->getColumnIndex($sheetColumnsName['start_date'], $sheet[0]);
            $sheetIndexForEndDate = $this->getColumnIndex($sheetColumnsName['end_date'], $sheet[0]);

            if ($sheetIndexForTeamMemberName === false || $sheetIndexForTotalBillableEffort === false || $sheetIndexForStartDate === false || $sheetIndexForEndDate === false) {
                return false;
            }

            if (count($projectsInSheet) == 0) {
                $projectsInSheet[] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'sheetIndex' => $sheetIndexForTotalBillableEffort
                ];
            }

            try {
                $usersData = $sheets->spreadsheet($sheetId)
                    ->range($range)
                    ->get();
            } catch (Exception $e) {
                return false;
            }

            foreach ($usersData as $sheetUser) {
                try {
                    $userNickname = $sheetUser[$sheetIndexForTeamMemberName];
                    $portalUsers = clone $users;
                    $portalUser = $portalUsers->where('nickname', $userNickname)->first();

                    if (! $portalUser) {
                        continue;
                    }

                    $billingStartDate = Carbon::create($sheetUser[$sheetIndexForStartDate]);
                    $billingEndDate = Carbon::create($sheetUser[$sheetIndexForEndDate]);
                    $currentDate = now('')->today();

                    if ($currentDate < $billingStartDate || $currentDate > $billingEndDate) {
                        continue;
                    }

                    $effortData = [
                        'portal_user' => $portalUser,
                        'sheet_user' => $sheetUser,
                        'project' => $project,
                        'billing_start_date' => $billingStartDate,
                        'billing_end_date' => $billingEndDate,
                        'sheet_index_for_billable_effort' => $sheetIndexForTotalBillableEffort,
                    ];

                    foreach ($projectsInSheet as $sheetProject) {
                        try {
                            $effortData['sheet_project'] = $sheetProject;
                            $this->updateEffort($effortData);
                            ProjectMeta::updateOrCreate(
                                [
                                    'key' => config('project.meta_keys.last_updated_at.key'),
                                    'project_id' => $project->id,
                                ],
                                [
                                    'value' => now('')
                                ]
                            );
                        } catch (Exception $e) {
                            continue;
                        }
                    }
                } catch (Exception $e) {
                    continue;
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getColumnIndex($columnName, $sheetColumns)
    {
        foreach ($sheetColumns as $columnIndex => $sheetColumn) {
            if (Str::lower($sheetColumn) == $columnName) {
                return $columnIndex;
            }
        }

        return false;
    }

    public function updateEffort(array $effortData)
    {
        $currentDate = now('')->today();
        $projectTeamMember = $effortData['portal_user']->projectTeamMembers()->active()->where('project_id', $effortData['sheet_project']['id'])->first();

        if (! $projectTeamMember) {
            return;
        }
        $latestProjectTeamMemberEffort = $projectTeamMember->projectTeamMemberEffort()
            ->where('added_on', '<', $currentDate)
            ->orderBy('added_on', 'DESC')->first();

        $billableEffort = $effortData['sheet_user'][$effortData['sheet_project']['sheetIndex']];

        if ($latestProjectTeamMemberEffort) {
            $previousEffortDate = Carbon::parse($latestProjectTeamMemberEffort->added_on);
            if ($previousEffortDate >= $effortData['billing_start_date'] && $previousEffortDate <= $effortData['billing_end_date']) {
                $billableEffort -= $latestProjectTeamMemberEffort->total_effort_in_effortsheet;
            }
        }

        ProjectTeamMemberEffort::updateOrCreate(
            [
                'project_team_member_id' => $projectTeamMember->id,
                'added_on' => $currentDate,
            ],
            [
                'actual_effort' => $billableEffort,
                'total_effort_in_effortsheet' => $effortData['sheet_user'][$effortData['sheet_project']['sheetIndex']],
            ]
        );
    }
}
