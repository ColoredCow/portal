<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveApplicantToApplicationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('hr_applicants_rounds', 'hr_application_round');
        Schema::rename('hr_applicant_reviews', 'hr_application_reviews');

        Schema::table('hr_application_round', function(Blueprint $table) {
            $table->unsignedInteger('hr_application_id')->nullable()->after('hr_applicant_id');
            $table->foreign('hr_application_id')->references('id')->on('hr_applications');
        });

        Schema::table('hr_application_reviews', function(Blueprint $table) {
            $table->unsignedInteger('hr_application_round_id')->nullable()->after('hr_applicant_round_id');
            $table->foreign('hr_application_round_id')->references('hr_application_id')->on('hr_application_round');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_reviews', function (Blueprint $table) {
            $table->dropForeign([ 'hr_application_round_id' ]);
            $table->dropColumn([ 'hr_application_round_id' ]);
        });

        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->dropForeign([ 'hr_application_id' ]);
            $table->dropColumn([ 'hr_application_id' ]);
        });

        Schema::rename('hr_application_round', 'hr_applicants_rounds');
        Schema::rename('hr_application_reviews', 'hr_applicant_reviews');
    }
}
