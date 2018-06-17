<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrApplicantReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_applicant_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hr_applicant_round_id')->unsigned();
            $table->string('review_key')->nullable();
            $table->text('review_value')->nullable();
            $table->timestamps();
        });

        Schema::table('hr_applicant_reviews', function (Blueprint $table) {
            $table->foreign('hr_applicant_round_id')->references('id')->on('hr_applicants_rounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_applicant_reviews', function (Blueprint $table) {
            $table->dropForeign(['hr_applicant_round_id']);
        });
    }
}
