<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRoundNameColumnOfCodetrekApplicantRoundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('codetrek_applicant_round_details', function (Blueprint $table) {
            $table->renameColumn('round_name', 'latest_round_name');
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
            $table->renameColumn('latest_round_name', 'round_name');
        });
    }
}
