<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartDateToHrJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_jobs', function (Blueprint $table) {
            $table-> date('start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     */

    public function down()
    {
        Schema::table('hr_jobs', function (Blueprint $table) {
            $table-> dropColumn(['start_date']);
        });
    }
}
