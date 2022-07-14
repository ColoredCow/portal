<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

class UpdateHrApplicationsWithHrChannel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applications', function (Blueprint $table) {
           $table->unsignedBigInteger('hr_channel_id')->nullable();

           $table->foreign('hr_channel_id')->references('id')->on('hr_channel');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
