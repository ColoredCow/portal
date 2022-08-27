<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->timestamp('meeting_duration')->nullable()->after('scheduled_end');
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
            $table->dropColumn(['meeting_duration']);
        });
    }
}