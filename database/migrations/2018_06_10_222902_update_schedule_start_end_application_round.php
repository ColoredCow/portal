<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateScheduleStartEndApplicationRound extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->timestamp('scheduled_end')->nullable()->after('scheduled_date');
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
            $table->dropColumn(['scheduled_end']);
        });
    }
}
