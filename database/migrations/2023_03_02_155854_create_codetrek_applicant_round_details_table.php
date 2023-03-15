<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodetrekApplicantRoundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codetrek_applicant_round_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('applicant_id');
            $table->string('round_name');
            $table->string('feedback');
            $table->timestamps();

            //foreign key constraint
            $table->foreign('applicant_id')
                  ->references('id')
                  ->on('code_trek_applicants')
                  ->onDelete('cascade');
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
            $table->dropForeign(['applicant_id']);
            $table->dropColumn(['applicant_id', 'round_name', 'qualified', 'feedback']);
        });
    }
}
