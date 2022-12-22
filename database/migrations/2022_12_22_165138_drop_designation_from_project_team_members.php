<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\HR\Entities\HrJobDesignation;

class DropDesignationFromProjectTeamMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->moveData();
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->dropColumn('desingation');
        });
        
    }
    private function moveData()
    {
        $projectTeamMembers = ProjectTeamMember::all();
        $jobDesignations = HrJobDesignation::all()->pluck('id', 'slug');
        foreach ($projectTeamMembers as $projectTeamMember) {
            $projectTeamMember->update(['designation_id'=>$jobDesignations[$projectTeamMember->designation]]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->string('desingation')->nullable();
        });
    }
}
