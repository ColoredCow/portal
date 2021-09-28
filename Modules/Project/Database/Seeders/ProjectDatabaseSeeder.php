<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;

class ProjectDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = Client::factory()->create();

        Project::factory()
            ->count(3)
            ->for($client)
            ->create();

        $this->call(ProjectTeamMemberDatabaseSeeder::class);
        $this->call(ProjectTeamMembersEffortDatabaseSeeder::class);
    }
}
