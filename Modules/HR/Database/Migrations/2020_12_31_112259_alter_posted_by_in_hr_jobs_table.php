<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPostedByInHrJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_jobs', function (Blueprint $table) {
            $table->dropColumn('posted_by');
        });
        Schema::table('hr_jobs', function (Blueprint $table) {
            $table->unsignedInteger('posted_by')->nullable();
            $table->foreign('posted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_jobs', function (Blueprint $table) {
            $table->dropForeign(['posted_by']);
            $table->dropColumn(['posted_by']);
        });
        Schema::table('hr_jobs', function (Blueprint $table) {
            $table->string('posted_by')->nullable();
        });
    }
}
