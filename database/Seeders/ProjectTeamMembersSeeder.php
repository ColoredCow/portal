<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\HR\Entities\HrJobDesignation;

class ProjectTeamMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectTeamMembers = ProjectTeamMember::all();
        $jobDesignations = HrJobDesignation::all()->pluck('id', 'slug');
        foreach ($projectTeamMembers as $projectTeamMember) {
            $projectTeamMember->update(['designation_id'=>$jobDesignations[$projectTeamMember->designation]]);
        }
    }
}
