<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrApplicantsRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_applicants_rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hr_applicant_id')->unsigned();
            $table->integer('hr_round_id')->unsigned();
            $table->timestamp('scheduled_date')->nullable();
            $table->integer('scheduled_person_id')->unsigned();
            $table->timestamp('conducted_date')->nullable();
            $table->integer('conducted_person_id')->unsigned()->nullable();
            $table->string('round_status')->nullable();
        });

        Schema::table('hr_applicants_rounds', function (Blueprint $table) {
            $table->foreign('hr_applicant_id')->references('id')->on('hr_applicants');
            $table->foreign('hr_round_id')->references('id')->on('hr_rounds');
            $table->foreign('scheduled_person_id')->references('id')->on('users');
            $table->foreign('conducted_person_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_applicants_rounds', function (Blueprint $table) {
            $table->dropForeign([
                'hr_applicant_id',
                'hr_round_id',
                'scheduled_person_id',
                'conducted_person_id',
            ]);
        });
    }
}
