<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrApplicationRejectionReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_application_rejection_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hr_application_round_id')->unsigned();
            $table->foreign('hr_application_round_id')->references('id')->on('hr_application_round');
            $table->string('reason_title');
            $table->text('reason_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_application_rejection_reasons');
    }
}
