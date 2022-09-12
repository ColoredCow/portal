<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualEndTImeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->timestamp('actual_end_time')->nullable()->after('scheduled_end');
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
            $table->dropColumn(['actual_end_time']);
        });
    }
}
