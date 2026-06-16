<?php

namespace Modules\Project\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Modules\User\Entities\User;

class ProjectDatabaseSeeder extends Seeder
{
    const CLIENTS = 5;
    const PROJECTS_PER_CLIENT = 2;
    const MEMBERS_PER_PROJECT = 3;
    const WORKDAYS = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProjectPermissionsTableSeeder::class);

        if (app()->environment('production')) {
            return;
        }

        // Idempotency: don't stack duplicate demo graphs on re-run.
        if (Client::query()->exists()) {
            return;
        }

        $this->seedConnectedGraph(
            self::CLIENTS,
            self::PROJECTS_PER_CLIENT,
            self::MEMBERS_PER_PROJECT,
            self::WORKDAYS
        );
    }

    /**
     * Build a connected clients -> projects -> team members -> efforts graph,
     * staffing team members from existing users.
     */
    public function seedConnectedGraph(int $clients, int $projectsPerClient, int $membersPerProject, int $workdays): void
    {
        $userIds = User::query()->pluck('id')->all();
        if (empty($userIds)) {
            $userIds = User::factory()->count($membersPerProject)->create()->pluck('id')->all();
        }

        $designations = array_keys(config('project.designation'));
        $workdayDates = $this->recentWeekdays($workdays);

        DB::transaction(function () use ($clients, $projectsPerClient, $membersPerProject, $userIds, $designations, $workdayDates) {
            Client::factory()->count($clients)->create()->each(
                function (Client $client) use ($projectsPerClient, $membersPerProject, $userIds, $designations, $workdayDates) {
                    Project::factory()->count($projectsPerClient)->create(['client_id' => $client->id])->each(
                        function (Project $project) use ($membersPerProject, $userIds, $designations, $workdayDates) {
                            foreach ($this->pickUsers($userIds, $membersPerProject) as $userId) {
                                $member = ProjectTeamMember::factory()->create([
                                    'project_id' => $project->id,
                                    'team_member_id' => $userId,
                                    'designation' => $designations[array_rand($designations)],
                                ]);
                                $this->seedEfforts($member, $workdayDates);
                            }
                        }
                    );
                }
            );
        });
    }

    private function seedEfforts(ProjectTeamMember $member, array $workdayDates): void
    {
        $runningTotal = 0;
        foreach ($workdayDates as $date) {
            $actual = rand(6, 9);
            $runningTotal += $actual;
            ProjectTeamMemberEffort::factory()->create([
                'project_team_member_id' => $member->id,
                'actual_effort' => $actual,
                'employee_actual_working_effort' => $actual,
                'total_effort_in_effortsheet' => $runningTotal,
                'total_employee_actual_working_effort' => $runningTotal,
                'added_on' => $date,
            ]);
        }
    }

    /**
     * @return array<int>
     */
    private function pickUsers(array $userIds, int $count): array
    {
        if (count($userIds) <= $count) {
            return $userIds;
        }
        $keys = (array) array_rand($userIds, $count);

        return array_map(fn ($key) => $userIds[$key], $keys);
    }

    /**
     * The most recent N weekdays, oldest first.
     *
     * @return array<\Carbon\Carbon>
     */
    private function recentWeekdays(int $count): array
    {
        $dates = [];
        $cursor = Carbon::today();
        while (count($dates) < $count) {
            if ($cursor->isWeekday()) {
                $dates[] = $cursor->copy();
            }
            $cursor->subDay();
        }

        return array_reverse($dates);
    }
}
