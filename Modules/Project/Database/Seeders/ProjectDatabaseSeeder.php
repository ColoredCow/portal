<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientAddress;
use Modules\Client\Entities\ClientBillingDetail;
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
        if (! app()->environment('production')) {
           $client = Client::factory()->create();
           Project::factory()
            ->count(3)
                ->for($client)
               ->create();
            ClientAddress::factory()->create();
            ClientBillingDetail::factory()->create();

        }

        $this->call(ProjectPermissionsTableSeeder::class);
        $this->call(ProjectTeamMemberDatabaseSeeder::class);
        $this->call(ProjectTeamMembersEffortDatabaseSeeder::class);
    }
}
