<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCodetrekApplicantRoundDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('codetrek_applicant_round_details', function (Blueprint $table) {
            $table->string('feedback')->nullable(true)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codetrek_applicant_round_details', function (Blueprint $table) {
            $table->dropColumn(['feedback']);
        });
    }
}
