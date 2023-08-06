<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hr_applicant_id');
            $table->unsignedInteger('hr_job_id');
            $table->string('status')->nullable();
            $table->string('resume')->nullable();
            $table->text('reason_for_eligibility')->nullable();
            $table->string('autoresponder_subject')->nullable();
            $table->text('autoresponder_body')->nullable();
            $table->timestamps();
        });

        Schema::table('hr_applications', function (Blueprint $table) {
            $table->foreign('hr_applicant_id')->references('id')->on('hr_applicants');
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
        Schema::dropIfExists('hr_applications', function (Blueprint $table) {
            $table->dropForeign([
                'hr_applicant_id',
                'hr_job_id',
            ]);
        });
    }
}
