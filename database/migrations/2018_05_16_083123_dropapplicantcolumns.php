<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dropapplicantcolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->dropForeign(['hr_job_id']);
            $table->dropColumn([
                'reason_for_eligibility',
                'autoresponder_subject',
                'autoresponder_body',
                'status',
                'resume',
                'hr_job_id'
            ]);
        });

        Schema::table('hr_application_reviews', function (Blueprint $table) {
            $table->dropColumn(['hr_applicant_round_id']);
        });

        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->dropColumn(['hr_applicant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->unsignedInteger('hr_applicant_id')->nullable();
        });

        Schema::table('hr_application_reviews', function (Blueprint $table) {
            $table->unsignedInteger('hr_applicant_round_id')->nullable();
        });

        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->string('status')->nullable();
            $table->string('resume')->nullable();
            $table->text('reason_for_eligibility')->nullable();
            $table->string('autoresponder_subject')->nullable();
            $table->text('autoresponder_body')->nullable();
            $table->unsignedInteger('hr_job_id')->nullable();
            $table->foreign('hr_job_id')->references('id')->on('hr_jobs');
        });
    }
}
