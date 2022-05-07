<?php

namespace Modules\Project\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMembersEffort;

class ProjectTeamMembersEffortDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            $projectTeamMember = ProjectTeamMember::factory()->create();
            $totalEffort = 0;
            for ($count = 0; $count < 10; $count++) {
                $actualEffort = rand(6, 9);
                $totalEffort += $actualEffort;
                ProjectTeamMembersEffort::create([
                    'project_team_member_id' => $projectTeamMember->id,
                    'actual_effort' => $actualEffort,
                    'total_effort_in_effortsheet' => $totalEffort,
                    'added_on' => Carbon::today()->subDays(10 - $count)
                ]);
            }
        }
    }
}
