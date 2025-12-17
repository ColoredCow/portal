<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicationRoundWithCalendarMeetingId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->unsignedBigInteger('calendar_meeting_id')->after('calendar_event')->nullable();
        });

        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->foreign('calendar_meeting_id')->references('id')->on('calendar_meetings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->dropForeign(['calendar_meeting_id']);
        });
    }
}
