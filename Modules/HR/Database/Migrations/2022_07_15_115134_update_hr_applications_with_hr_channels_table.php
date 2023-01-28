<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrApplicationsWithHrChannelsTable extends Migration
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

            $table->foreign('hr_channel_id')->references('id')->on('hr_channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->dropForeign(['hr_channel_id']);
            $table->dropColumn(['hr_channel_id']);
        });
    }
}
