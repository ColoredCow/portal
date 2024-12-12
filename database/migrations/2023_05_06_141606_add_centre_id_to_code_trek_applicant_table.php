<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCentreIdToCodeTrekApplicantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::table('code_trek_applicants', function (Blueprint $table) {
    //         $table->unsignedBigInteger('centre_id')->nullable();
    //         $table->foreign('centre_id')->references('id')->on('office_locations');
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::table('code_trek_applicants', function (Blueprint $table) {
    //         $table->dropForeign('centre_id');
    //         $table->dropColumn('centre_id');
    //     });
    // }
}
