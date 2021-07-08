<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrFollowUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_follow_ups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('hr_application_round_id');
            $table->text('checklist')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedInteger('assigned_to')->nullable();
            $table->unsignedInteger('conducted_by')->nullable();
            $table->timestamps();

            $table->foreign('hr_application_round_id')->references('id')->on('hr_application_round')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('conducted_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_follow_ups');
    }
}
