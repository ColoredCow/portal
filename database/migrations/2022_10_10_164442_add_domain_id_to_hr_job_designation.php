<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDomainIdToHrJobDesignation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_job_designation', function (Blueprint $table) {
            $table->unsignedBigInteger('domain_id')->nullable();
            $table->foreign('domain_id')->references('id')->on('hr_job_domains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_job_designation', function (Blueprint $table) {
            $table->dropForeign(['domain_id']);
            $table->dropColumn(['domain_id']);
        });
    }
}
