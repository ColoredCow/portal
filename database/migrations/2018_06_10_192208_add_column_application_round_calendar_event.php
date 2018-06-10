<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnApplicationRoundCalendarEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->string('calendar_event')->nullable()->after('hr_round_id');
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
            $table->dropColumn(['calendar_event']);
        });
    }
}
