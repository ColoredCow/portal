<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupOfficeLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('code_trek_applicants', function (Blueprint $table) {
            $table->dropForeign(['centre_id']);
            $table->dropColumn('centre_id');
        });
        Schema::dropIfExists('office_locations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('office_locations', function (Blueprint $table) {
            $table->id();
            $table->string('centre_name');
            $table->integer('centre_head_id')->unsigned();
            $table->integer('capacity');
            $table->integer('current_people_count');
            $table->timestamps();
        });
        Schema::table('office_locations', function (Blueprint $table) {
            $table->foreign('centre_head_id')->references('id')->on('users');
        });
        Schema::table('code_trek_applicants', function (Blueprint $table) {
            $table->unsignedBigInteger('centre_id')->nullable();
            $table->foreign('centre_id')->references('id')->on('office_locations');
        });
    }
}
