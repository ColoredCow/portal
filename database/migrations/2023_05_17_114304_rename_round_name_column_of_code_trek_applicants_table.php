<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRoundNameColumnOfCodeTrekApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('code_trek_applicants', function (Blueprint $table) {
            $table->renameColumn('round_name', 'current_round_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('code_trek_applicants', function (Blueprint $table) {
            $table->renameColumn('current_round_name', 'round_name');
        });
    }
}
