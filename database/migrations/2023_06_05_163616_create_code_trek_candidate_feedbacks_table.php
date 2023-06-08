<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeTrekCandidateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_trek_candidate_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('candidate_id');
            $table->integer('posted_by')->unsigned();
            $table->unsignedInteger('category_id');
            $table->string('latest_round_name');
            $table->string('feedback');
            $table->string('feedback_type');
            $table->date('posted_on');
            $table->timestamps();

            $table->foreign('posted_by')->references('id')->on('users');
            $table->foreign('candidate_id')->references('id')->on('code_trek_applicants');
            $table->foreign('category_id')->references('id')->on('code_trek_feedback_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_trek_candidate_feedback');
    }
}
