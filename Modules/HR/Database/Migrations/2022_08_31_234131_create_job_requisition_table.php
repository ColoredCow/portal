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
            $table->unsignedInteger('domain_id');
            $table->unsignedInteger('opportunity_id');
            $table->timestamps();

            $table->foreign('domain_id')->references('id')->on('hr_job_domains');
            $table->foreign('opportunity_id')->references('id')->on('hr_jobs');
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
                'opportunity_id',
            ]);
        });
    }
}
