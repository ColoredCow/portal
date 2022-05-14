<?php

namespace Modules\Project\Console;

use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Revolution\Google\Sheets\Sheets;

class SyncEffortsheet extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sync:effortsheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands syncs the effortsheets with the projects';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projects = Project::where('status', 'active')->get();
        $users = User::with('projectTeamMembers');

        foreach ($projects as $project) {
            $effortSheetURL = $project->effort_sheet_url;

            if (! $effortSheetURL) {
                continue;
            }

            $matchesId = [];
            $matchesSheetId = preg_match('/.*[^-\w]([-\w]{25,})[^-\w]?.*/', $effortSheetURL, $matchesId);

            if (! $matchesSheetId) {
                continue;
            }

            $sheetId = $matchesId[1];
            $sheet = new Sheets();
            $projectMembersCount = $project->teamMembers()->count();
            $range = 'C2:G' . ($projectMembersCount + 1); // this will depend on the number of people on the project

            try {
                $sheets = $sheet->spreadsheet($sheetId)
                                ->range($range)
                                ->get();
            } catch (Exception $e) {
                continue;
            }

            foreach ($sheets as $user) {
                $userNickname = $user[0];
                $portalUsers = clone $users;
                $portalUser = $portalUsers->where('nickname', $userNickname)->first();

                if (! $portalUser) {
                    continue;
                }

                $projectMonth = Carbon::create($user[1])->month;
                $currentMonth = now()->month;

                if ($projectMonth !== $currentMonth) {
                    continue;
                }

                $projectTeamMember = $portalUser->projectTeamMembers()->active()->where('project_id', $project->id)->first();

                if (! $projectTeamMember) {
                    continue;
                }

                $latestProjectTeamMemberEffort = $projectTeamMember->projectTeamMemberEffort()->orderBy('added_on', 'DESC')->first();
                $actual_effort = $user[4];

                if ($latestProjectTeamMemberEffort) {
                    $previous_effort_date = Carbon::parse($latestProjectTeamMemberEffort->added_on);

                    if ($previous_effort_date->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                        continue;
                    } elseif ($previous_effort_date->format('Y-m') == Carbon::now()->format('Y-m')) {
                        $actual_effort -= $latestProjectTeamMemberEffort->total_effort_in_effortsheet;
                    }
                }

                ProjectTeamMemberEffort::create([
                    'project_team_member_id' => $projectTeamMember->id,
                    'actual_effort' => $actual_effort,
                    'total_effort_in_effortsheet' => $user[4],
                    'added_on' => now(),
                ]);
            }
        }
    }
}
