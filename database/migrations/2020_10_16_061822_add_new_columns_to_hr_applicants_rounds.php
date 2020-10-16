<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToHrApplicantsRounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_round', function (Blueprint $table) {
            $table->integer('trial_round_id')->unsigned()->nullable()->after('hr_round_id');
            $table->foreign('trial_round_id')->references('id')->on('hr_rounds');
            $table->integer('is_latest_trial_round')->unsigned()->default(0)->after('is_latest');
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
            $table->dropForeign(['trial_round_id']);
            $table->dropColumn(['trial_round_id', 'is_latest_trial_round']);
        });
    }
}
