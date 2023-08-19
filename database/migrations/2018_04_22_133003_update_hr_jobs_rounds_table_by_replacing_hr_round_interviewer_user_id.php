<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHrJobsRoundsTableByReplacingHrRoundInterviewerUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_jobs_rounds', function (Blueprint $table) {
            $table->dropColumn('hr_round_interviewer');
        });

        Schema::table('hr_jobs_rounds', function (Blueprint $table) {
            $table->unsignedInteger('hr_round_interviewer_id')->nullable();
            $table->foreign('hr_round_interviewer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_jobs_rounds', function (Blueprint $table) {
            $table->dropForeign(['hr_round_interviewer_id']);
        });
    }
}
