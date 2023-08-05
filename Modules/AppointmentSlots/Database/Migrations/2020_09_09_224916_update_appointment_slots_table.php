<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAppointmentSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_slots', function (Blueprint $table) {
            $table->string('recurrence')->default('none')->after('end_time');
            $table->bigInteger('parent_appointment_slot_id')->nullable()->unsigned()->after('reserved_for_type');
            $table->foreign('parent_appointment_slot_id')->references('id')->on('appointment_slots')->onDelete('cascade');
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
        Schema::table('appointment_slots', function (Blueprint $table) {
            $table->dropForeign(['parent_appointment_slot_id']);
            $table->dropColumn(['recurrence', 'parent_appointment_slot_id', 'deleted_at']);
        });
    }
}
