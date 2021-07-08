<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCalenderMeetingServiceWithHangoutLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_meetings', function (Blueprint $table) {
            $table->string('hangout_link')->nullable()->after('calendar_event');
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
            $table->dropColumn('hangout_link');
        });
    }
}
