<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEvaluationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_round_review_evaluations', function (Blueprint $table) {
            $table->dropForeign(['round_review_id']);
            $table->dropColumn(['round_review_id', 'score']);
        });

        Schema::rename('hr_application_round_review_evaluations', 'hr_application_round_evaluation');

        Schema::table('hr_application_round_evaluation', function (Blueprint $table) {
            $table->integer('application_round_id')->unsigned()->after('id');
            $table->foreign('application_round_id')->references('id')->on('hr_application_round');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_round_evaluation', function (Blueprint $table) {
            $table->dropForeign(['application_round_id']);
            $table->dropColumn('application_round_id');
        });

        Schema::rename('hr_application_round_evaluation', 'hr_application_round_review_evaluations');

        Schema::table('hr_application_round_review_evaluations', function (Blueprint $table) {
            $table->integer('round_review_id')->unsigned();
            $table->string('score');
            $table->foreign('round_review_id')->references('id')->on('hr_application_round_reviews');
        });
    }
}
