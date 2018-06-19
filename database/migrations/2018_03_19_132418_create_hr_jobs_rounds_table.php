<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrJobsRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_jobs_rounds', function (Blueprint $table) {
            $table->integer('hr_job_id')->unsigned();
            $table->integer('hr_round_id')->unsigned();
            $table->string('hr_round_interviewer')->nullable();
        });

        Schema::table('hr_jobs_rounds', function (Blueprint $table) {
            $table->foreign('hr_job_id')->references('id')->on('hr_jobs');
            $table->foreign('hr_round_id')->references('id')->on('hr_rounds');
            $table->primary(['hr_job_id', 'hr_round_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_jobs_rounds', function (Blueprint $table) {
            $table->dropForeign(['hr_job_id', 'hr_round_id']);
        });
    }
}
