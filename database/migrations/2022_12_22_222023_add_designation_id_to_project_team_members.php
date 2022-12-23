<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\HR\Entities\HrJobDesignation;

class AddDesignationIdToProjectTeamMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->foreign('designation_id')->references('id')->on('hr_job_designation');
        });
        $this->moveData();
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->dropColumn('designation');
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
            $table->dropForeign(['designation_id']);
            $table->dropColumn(['designation_id']);
        });
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->string('designation')->nullable();
        });
    }
}
