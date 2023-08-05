<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStartedOnColumnToNullableInProjectTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->timestamp('started_on')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->timestamp('started_on')->nullable(false)->change();
        });
    }
}
