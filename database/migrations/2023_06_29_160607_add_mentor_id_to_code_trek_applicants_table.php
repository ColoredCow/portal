<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMentorIdToCodeTrekApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('code_trek_applicants', function (Blueprint $table) {
            $table->integer('mentor_id')->unsigned()->nullable();

           
        });
        Schema::table('code_trek_applicants', function (Blueprint $table) {

            $table->foreign('mentor_id')->references('id')->on('users');
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
            $table->dropForeign([
                'mentor_id'
            ]);
        });
    }
}
