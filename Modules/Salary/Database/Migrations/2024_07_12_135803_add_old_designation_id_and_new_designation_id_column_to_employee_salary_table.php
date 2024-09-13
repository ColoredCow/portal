<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldDesignationIdAndNewDesignationIdColumnToEmployeeSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_salaries', function (Blueprint $table) {
            $table->bigInteger('old_designation_id')->unsigned()->nullable();
            $table->bigInteger('new_designation_id')->unsigned()->nullable();
            $table->foreign('old_designation_id')->references('id')->on('hr_job_designation');
            $table->foreign('new_designation_id')->references('id')->on('hr_job_designation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_salaries', function (Blueprint $table) {
            $table->dropForeign('new_designation_id');
            $table->dropForeign('old_designation_id');
            $table->dropColumn(['new_designation_id', 'old_designation_id']);
        });
    }
}
