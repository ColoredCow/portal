<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeMonthlyEstimatedHoursNullableOnProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_estimated_hours_nullable_on_projects', function (Blueprint $table) {
            $table->float('monthly_estimated_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_estimated_hours_nullable_on_projects', function (Blueprint $table) {
            $table->float('monthly_estimated_hours');
        });
    }
}
