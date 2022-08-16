<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectCalendarMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_calendar_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prospect_id');
            $table->unsignedBigInteger('calendar_meeting_id');
            $table->timestamps();
        });

        Schema::table('prospect_calendar_meeting', function (Blueprint $table) {
            $table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('cascade');
            $table->foreign('calendar_meeting_id')->references('id')->on('calendar_meetings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospect_calendar_meeting', function (Blueprint $table) {
            $table->dropForeign(['prospect_id']);
            $table->dropForeign(['calendar_meeting_id']);
        });

        Schema::dropIfExists('prospect_calendar_meeting');
    }
}
