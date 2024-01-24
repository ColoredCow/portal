<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('status')->default('free');
            $table->bigInteger('application_round_id')->nullable();
            $table->bigInteger('reserved_for_id')->nullable();
            $table->string('reserved_for_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_slots');
    }
}
