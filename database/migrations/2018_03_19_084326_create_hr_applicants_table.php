<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->integer('hr_job_id')->unsigned();
            $table->string('status')->nullable();
            $table->string('resume')->nullable();
            $table->timestamps();
        });

        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->foreign('hr_job_id')->references('id')->on('hr_jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_applicants', function (Blueprint $table) {
            $table->dropForeign(['hr_job_id']);
        });
    }
}
