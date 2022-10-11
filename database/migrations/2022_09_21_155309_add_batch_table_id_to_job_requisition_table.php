<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatchTableIdToJobRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_requisition', function (Blueprint $table) {
            $table->integer('hired_batch_id')->unsigned()->nullable();
            $table->foreign('hired_batch_id')->references('id')->on('hr_requisition_hired_batches')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_requisition', function (Blueprint $table) {
            $table->dropForeign(['hired_batch_id']);
        });
    }
}
