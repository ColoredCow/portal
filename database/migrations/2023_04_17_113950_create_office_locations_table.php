<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_locations');
    }
}
