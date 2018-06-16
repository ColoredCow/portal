<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('hr_evaluation_parameter_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_id')->unsigned();
            $table->string('value');
            $table->softDeletes();
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
            $table->integer('option_id')->unsigned();
            $table->string('score');
            $table->string('comment')->nullable();
            $table->timestamps();
        });

        Schema::table('hr_evaluation_parameter_options', function (Blueprint $table) {
            $table->foreign('evaluation_id')->references('id')->on('hr_evaluation_parameters');
        });

        Schema::table('hr_round_evaluation', function (Blueprint $table) {
            $table->foreign('evaluation_id')->references('id')->on('hr_evaluation_parameters');
            $table->foreign('round_id')->references('id')->on('hr_rounds');
            $table->primary(['evaluation_id', 'round_id']);
        });

        Schema::table('hr_application_round_review_evaluations', function (Blueprint $table) {
            $table->foreign('round_review_id')->references('id')->on('hr_application_round_reviews');
            $table->foreign('evaluation_id')->references('id')->on('hr_evaluation_parameters');
            $table->foreign('option_id')->references('id')->on('hr_evaluation_parameter_options');
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
            $table->dropForeign(['round_review_id', 'evaluation_id', 'option_id']);
        });

        Schema::dropIfExists('hr_round_evaluation', function (Blueprint $table) {
            $table->dropForeign(['evaluation_id', 'round_id']);
        });

        Schema::dropIfExists('hr_evaluation_parameter_options', function (Blueprint $table) {
            $table->dropForeign(['evaluation_id']);
        });

        Schema::dropIfExists('hr_evaluation_parameters');
    }
}
