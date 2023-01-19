<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropJobIdFromHrResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_resources', function (Blueprint $table) {
            $table->dropForeign(['job_id']); 
            $table->dropColumn(['job_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_resources', function (Blueprint $table) {
            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('hr_jobs')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }
}
