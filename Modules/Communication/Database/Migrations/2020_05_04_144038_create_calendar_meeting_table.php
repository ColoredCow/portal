<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('organizer_id')->nullable();
            $table->text('attendees')->nullable();
            $table->text('event_title')->nullable();
            $table->datetime('start_at')->nullable();
            $table->datetime('ends_at')->nullable();
            $table->string('calendar_event')->nullable();
            $table->timestamps();
        });

        Schema::table('calendar_meetings', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('organizer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendar_meetings', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['organizer_id']);
        });

        Schema::dropIfExists('calendar_meetings');
    }
}
