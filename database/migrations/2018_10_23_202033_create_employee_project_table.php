<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_project', function (Blueprint $table) {
            $table->integer('employee_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->string('contribution_type')->nullable();
        });

        Schema::table('employee_project', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->primary(['employee_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_project', function (Blueprint $table) {
            Schema::dropIfExists('employee_project');
        });
    }
}
