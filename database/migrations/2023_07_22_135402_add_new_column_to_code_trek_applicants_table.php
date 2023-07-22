<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToCodeTrekApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('code_trek_applicants', function (Blueprint $table) {
            $table->unsignedBigInteger('centre_id')->nullable(false)->change();
            $table->integer('mentor_id')->unsigned()->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
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
 
        });
    }
}
