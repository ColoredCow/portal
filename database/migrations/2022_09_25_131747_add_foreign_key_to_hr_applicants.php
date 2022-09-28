<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToHrApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->integer('job_id')->unsigned()->nullable();
            $table->foreign('job_id')->references('id')->on('hr_jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->dropForeign('hr_applicants_job_id_foreign');
            $table->dropColumn(['job_id']);
        });
    }
}
