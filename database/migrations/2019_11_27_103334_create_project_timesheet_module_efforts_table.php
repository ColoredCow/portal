<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTimesheetModuleEffortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_timesheet_module_efforts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedInteger('user_id');
            $table->string('subtask');
            $table->dateTime('spent_at');
            $table->timestamps();
        });

        Schema::table('project_timesheet_module_efforts', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('project_timesheet_modules');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_timesheet_module_efforts', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('project_timesheet_module_efforts');
    }
}
