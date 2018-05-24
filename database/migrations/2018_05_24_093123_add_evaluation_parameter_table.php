<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvaluationParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_evaluation_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('hr_round_evaluation', function (Blueprint $table) {
            $table->integer('evaluation_id')->unsigned();
            $table->integer('round_id')->unsigned();
        });

        Schema::create('hr_application_round_review_evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('round_review_id')->unsigned();
            $table->integer('evaluation_id')->unsigned();
            $table->string('score');
            $table->string('comment')->nullable();
            $table->timestamps();
        });

        Schema::table('hr_round_evaluation', function (Blueprint $table) {
            $table->foreign('evaluation_id')->references('id')->on('hr_evaluation_parameters');
            $table->foreign('round_id')->references('id')->on('hr_rounds');
            $table->primary(['evaluation_id', 'round_id']);
        });

        Schema::table('hr_application_round_review_evaluations', function (Blueprint $table) {
            $table->foreign('round_review_id')->references('id')->on('hr_application_round_reviews');
            $table->foreign('evaluation_id')->references('id')->on('hr_evaluation_parameters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_application_round_review_evaluations', function (Blueprint $table) {
            $table->dropForeign(['round_review_id', 'evaluation_id']);
        });

        Schema::dropIfExists('hr_round_evaluation', function (Blueprint $table) {
            $table->dropForeign(['evaluation_id', 'round_id']);
        });

        Schema::dropIfExists('hr_evaluation_parameters');
    }
}
