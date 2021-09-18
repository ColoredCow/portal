<?php

namespace Modules\Project\Console;

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
        // fetch all active projects

        $projects = Project::where('status', 'active')->get();

        $users = User::with('projectTeamMembers');

        // loop over each project
        foreach ($projects as $project) {
            $effortSheetURL = $project->effort_sheet_url;

            // check if we have set the effortsheet url
            if ($effortSheetURL) {

                // $spreadSheetId = '1g4kGalUsI-78MNJo1EyPbok5-P28fbbc2vjB-fK1XOo'; // need to get from project efforstsheet url

                $matchesId = [];
                $matchesSheetId = [];
                preg_match('/.*[^-\w]([-\w]{25,})[^-\w]?.*/', $effortSheetURL, $matchesId);
                preg_match('/gid=([0-9]+)/', $effortSheetURL, $matchesSheetId);

                $sheetId = $matchesId[1];
                // $subSheetID = '756414304'; // get from efforstsheet url
                $subSheetID = $matchesSheetId[1];

                $sheet = new Sheets();

                $projectMembersCount = $project->teamMembers()->count();

                $range = 'C2:G' . ($projectMembersCount + 1); // this will depend on the number of people on the project

                $sheets = $sheet->spreadsheet($sheetId)
                                ->sheetById($subSheetID)
                                ->range($range)
                                ->get();

                // loop over each person in the project and add his hours in the database
                foreach ($sheets as $user) {
                    $userNickname = $user[0];

                    $portalUser = $users->where('nickname', $userNickname)->first();

                    // check if we have a user in the portal with the given nickname
                    if ($portalUser) {
                        $projectTeamMember = $portalUser->projectTeamMembers()->where('project_id', $project->id)->first();

                        if ($projectTeamMember) {
                            $projectTeamMemberId = $projectTeamMember->id;

                            // need to check if we alreay have this member's entry for this project on a particular day

                            // finally create an entry for effort
                            ProjectTeamMemberEffort::create([
                                'project_team_member_id' => $projectTeamMemberId,
                                'actual_effort' => 8,
                                'total_effort_in_effortsheet' => $user[4],
                                'added_on' => now(),
                            ]);
                        }
                    }
                }
            }
        }
    }
}
