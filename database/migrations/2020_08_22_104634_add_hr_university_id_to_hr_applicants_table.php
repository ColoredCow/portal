<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHrUniversityIdToHrApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->foreignId('hr_university_id');
            $table->foreign('hr_university_id')->references('id')->on('hr_universities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            //
        });
    }
}
