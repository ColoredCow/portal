<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Spatie\Permission\Models\Permission;

class ProjectDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::updateOrCreate(['name' => 'projects.create']);
        Permission::updateOrCreate(['name' => 'projects.view']);
        Permission::updateOrCreate(['name' => 'projects.update']);
        Permission::updateOrCreate(['name' => 'projects.delete']);

        if (! app()->environment('production')) {
            $client = Client::factory()->create();
            Project::factory()
                ->count(3)
                ->for($client)
                ->create();
        }

        $projectManager = Role::where(['name' => 'project-manager'])->first();
        $projectManager->givePermissionTo([
            'projects.view',
        ]);

        $this->call(ProjectTeamMemberDatabaseSeeder::class);
        $this->call(ProjectTeamMembersEffortDatabaseSeeder::class);
    }
}
