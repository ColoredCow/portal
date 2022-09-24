<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('location')->nullable();
            $table->integer('capacity')->nullable();
            $table->unsignedInteger('center_head')->nullable();
            $table->timestamps();
        });

        Schema::table('office_locations', function (Blueprint $table) {
            $table->foreign('center_head')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_locations', function (Blueprint $table) {
            $table->dropForeign(['center_head']);
        });
    }
}
