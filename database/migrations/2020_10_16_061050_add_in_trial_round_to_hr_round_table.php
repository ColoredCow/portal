<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInTrialRoundToHrRoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_rounds', function (Blueprint $table) {
            $table->integer('in_trial_round')->default(0);
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
            $table->dropColumn(['in_trial_round']);
        });
    }
}
