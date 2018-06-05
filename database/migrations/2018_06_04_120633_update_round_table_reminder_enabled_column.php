<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRoundTableReminderEnabledColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_rounds', function (Blueprint $table) {
            $table->boolean('reminder_enabled')->default(false)->after('guidelines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_rounds', function (Blueprint $table) {
            $table->dropColumn(['reminder_enabled']);
        });
    }
}
