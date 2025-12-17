<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedInteger('hr_id')->nullable();
            $table->unsignedInteger('mentor_id')->nullable();
            $table->unsignedInteger('manager_id')->nullable();
            $table->foreign('hr_id')->references('id')->on('employees');
            $table->foreign('mentor_id')->references('id')->on('employees');
            $table->foreign('manager_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('hr_id');
            $table->dropForeign('mentor_id');
            $table->dropForeign('manager_id');
        });
    }
}
