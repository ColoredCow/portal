<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeActualEffortsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_team_members_effort', function (Blueprint $table) {
            $table->float('employee_actual_working_effort');
            $table->float('total_employee_actual_working_effort');
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
            $table->dropColumn(['employee_actual_working_effort', 'total_employee_actual_working_effort']);
        });
    }
}
