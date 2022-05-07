<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Project\Entities\ProjectTeamMember;

class ProjectTeamMemberDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            ProjectTeamMember::factory()
            ->count(2)
            ->create();
        }
    }
}
