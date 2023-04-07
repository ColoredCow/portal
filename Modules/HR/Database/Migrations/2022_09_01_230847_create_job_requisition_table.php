<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_requisition', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domain_id');
            $table->unsignedInteger('job_id');
            $table->timestamps();

            $table->foreign('domain_id')->references('id')->on('hr_job_domains');
            $table->foreign('job_id')->references('id')->on('hr_jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_requisition', function (Blueprint $table) {
            $table->dropForeign([
                'domain_id',
                'job_id',
            ]);
        });
    }
}
