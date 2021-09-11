<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesForEffortTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type')->after('id')->default(array_keys(config('project.type'))[0]);
            $table->float('total_estimated_hours')->nullable()->after('effort_sheet_url');
            $table->float('monthly_estimated_hours')->after('total_estimated_hours');
        });

        Schema::rename('project_resources', 'project_team_members');

        Schema::table('project_team_members', function (Blueprint $table) {
            $table->renameColumn('resource_id', 'team_member_id');
            $table->timestamp('started_on')->after('designation');
            $table->timestamp('ended_on')->nullable()->after('started_on');
            $table->float('daily_expected_effort')->after('designation');
        });

        Schema::create('project_team_members_effort', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('project_team_member_id');
            $table->float('actual_effort');
            $table->float('total_effort_in_effortsheet');
            $table->timestamp('added_on');
            $table->timestamps();
            $table->foreign('project_team_member_id')->references('id')->on('project_team_members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['type', 'total_estimated_hours', 'monthly_estimated_hours']);
        });

        Schema::table('project_team_members', function (Blueprint $table) {
            $table->renameColumn('team_member_id', 'resource_id');
            $table->dropColumn(['started_on', 'ended_on', 'daily_expected_effort']);
        });

        Schema::rename('project_team_members', 'project_resources');

        Schema::dropIfExists('project_team_members_effort');
    }
}
