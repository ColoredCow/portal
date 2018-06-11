<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvaluationSegment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_evaluation_segments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('hr_round_segment', function (Blueprint $table) {
            $table->integer('segment_id')->unsigned();
            $table->integer('round_id')->unsigned();
            $table->foreign('segment_id')->references('id')->on('hr_evaluation_segments');
            $table->foreign('round_id')->references('id')->on('hr_rounds');
            $table->primary(['segment_id', 'round_id']);
        });

        Schema::table('hr_evaluation_parameters', function (Blueprint $table) {
            $table->integer('segment_id')->unsigned()->nullable()->after('id');
            $table->foreign('segment_id')->references('id')->on('hr_evaluation_segments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_evaluation_parameters', function (Blueprint $table) {
            $table->dropForeign(['segment_id']);
            $table->dropColumn('segment_id');
        });

        Schema::dropIfExists('hr_round_segment', function (Blueprint $table) {
            $table->dropForeign(['segment_id', 'round_id']);
        });

        Schema::dropIfExists('hr_evaluation_segments');
    }
}
