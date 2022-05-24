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
            try {
                $effortSheetUrl = $project->effort_sheet_url;

                if (! $effortSheetUrl) {
                    continue;
                }

                $correctedEffortsheetUrl = [];
                
                // This preg match is used to filter the gid form the google sheet url so that we always get the first sheet from the google sheet
                $isSyntaxMatching = preg_match('/.*[^-\w]([-\w]{25,})[^-\w]?.*/', $effortSheetUrl, $correctedEffortsheetUrl);

                if (! $isSyntaxMatching) {
                    continue;
                }

                $sheetId = $correctedEffortsheetUrl[1];
                $sheet = new Sheets();
                $projectMembersCount = $project->teamMembers()->count();
                $range = 'C2:G' . ($projectMembersCount + 1); // this will depend on the number of people on the project

                try {
                    $usersData = $sheet->spreadsheet($sheetId)
                                    ->range($range)
                                    ->get();
                } catch (Exception $e) {
                    continue;
                }

                foreach ($usersData as $sheetUser) {
                    $userNickname = $sheetUser[0];
                    $portalUsers = clone $users;
                    $portalUser = $portalUsers->where('nickname', $userNickname)->first();

                    if (! $portalUser) {
                        continue;
                    }

                    $billingStartDate = Carbon::create($sheetUser[1]);
                    $billingEndDate = Carbon::create($sheetUser[2]);
                    $currentDate = now(config('constants.timezone.indian'))->today();

                    if ($currentDate < $billingStartDate || $currentDate > $billingEndDate) {
                        continue;
                    }

                    $projectTeamMember = $portalUser->projectTeamMembers()->active()->where('project_id', $project->id)->first();

                    if (! $projectTeamMember) {
                        continue;
                    }

                    $latestProjectTeamMemberEffort = $projectTeamMember->projectTeamMemberEffort()
                        ->where('added_on', '<', $currentDate)
                        ->orderBy('added_on', 'DESC')->first();
                    $actualEffort = $sheetUser[4];

                    if ($latestProjectTeamMemberEffort) {
                        $previousEffortDate = Carbon::parse($latestProjectTeamMemberEffort->added_on);

                        if ($previousEffortDate >= $billingStartDate && $previousEffortDate <= $billingEndDate) {
                            $actualEffort -= $latestProjectTeamMemberEffort->total_effort_in_effortsheet;
                        }
                    }

                    ProjectTeamMemberEffort::updateOrCreate(
                        [
                            'project_team_member_id' => $projectTeamMember->id,
                            'added_on' => $currentDate,
                        ],
                        [
                            'actual_effort' => $actualEffort,
                            'total_effort_in_effortsheet' => $sheetUser[4],
                        ]
                    );
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }
}
