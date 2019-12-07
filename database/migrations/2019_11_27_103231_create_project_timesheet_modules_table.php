<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTimesheetModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_timesheet_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_timesheet_id');
            $table->string('name');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('project_timesheet_modules', function (Blueprint $table) {
            $table->foreign('project_timesheet_id')->references('id')->on('project_timesheets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_timesheet_modules', function (Blueprint $table) {
            $table->dropForeign(['project_timesheet_id']);
        });
        Schema::dropIfExists('project_timesheet_modules');
    }
}
