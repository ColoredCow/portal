<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrApplicationAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_application_analysis', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('application_id');
            $table->text('ai_instruction');
            $table->text('ai_prompt');
            $table->string('resume_link');
            $table->text('analysis');
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('hr_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_application_analysis');
    }
}
