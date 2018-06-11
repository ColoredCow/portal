<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRoundReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('hr_application_round_evaluation', 'hr_application_evaluations');

        Schema::table('hr_application_evaluations', function (Blueprint $table) {
            $table->integer('application_id')->unsigned()->nullable()->after('id');
            $table->foreign('application_id')->references('id')->on('hr_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_evaluations', function (Blueprint $table) {
            $table->dropForeign(['application_id']);
            $table->dropColumn('application_id');
        });

        Schema::rename('hr_application_evaluations', 'hr_application_round_evaluation');
    }
}
