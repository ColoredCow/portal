<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrApplicationSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_application_segments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('evaluation_segment_id');
            $table->unsignedInteger('application_round_id');
            $table->text('next_interview_comments')->nullable();
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('hr_applications');
            $table->foreign('evaluation_segment_id')->references('id')->on('hr_evaluation_segments');
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
        Schema::dropIfExists('hr_application_segments');
    }
}
