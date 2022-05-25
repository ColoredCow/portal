<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAutoUpdateTimeCapabilityFromTeamMembersEffortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_team_members_effort', function (Blueprint $table) {
            $table->date('added_on')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_team_members_effort', function (Blueprint $table) {
            $table->dateTime('added_on')->change();
        });
    }
}
