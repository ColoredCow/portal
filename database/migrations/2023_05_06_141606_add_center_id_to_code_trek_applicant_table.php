<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCenterIdToCodeTrekApplicantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('code_trek_applicants', function (Blueprint $table) {
            $table->unsignedBigInteger('center_id')->nullable();
            $table->foreign('center_id')->references('id')->on('office_locations');
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
            $table->dropForeign('center_id');
            $table->dropColumn('center_id');
        });
    }
}
