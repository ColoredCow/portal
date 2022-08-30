<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingEngagementColumnToProjectTeamMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_team_members', function (Blueprint $table) {
            $table->float('billing_engagement')->nullable()->after('ended_on');
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
            $table->dropColumn('billing_engagement');
        });
    }
}
