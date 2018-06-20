<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHRApplicationMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_application_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hr_application_id');
            $table->text('form_data');
            $table->timestamps();
        });

        Schema::table('hr_application_meta', function (Blueprint $table) {
            $table->foreign('hr_application_id')->references('id')->on('hr_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_application_meta');
    }
}
