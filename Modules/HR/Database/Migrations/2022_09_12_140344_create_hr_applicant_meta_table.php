<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrApplicantMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_applicant_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value');
            $table->unsignedInteger('hr_applicant_id');
            $table->timestamps();
        });

        Schema::table('hr_applicant_meta', function (Blueprint $table) {
            $table->foreign('hr_applicant_id')->references('id')->on('hr_applicants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_applicant_meta', function (Blueprint $table) {
            $table->dropForeign(['hr_applicant_id']);
        });
    }
}
