<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->string('recurrence')->default('none');
            $table->boolean('is_booked')->default(false);
            $table->string('meeting_url')->nullable();
            $table->unsignedInteger('hr_parent_slot_id')->nullable();
            $table->unsignedInteger('hr_applicant_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hr_applicant_id')->references('id')->on('hr_applicants');
            $table->foreign('hr_parent_slot_id')->references('id')->on('hr_slots')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_slots');
    }
}
