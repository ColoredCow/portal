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
            $table->integer('batch_table_id')->unsigned()->nullable();
            $table->foreign('batch_table_id')->references('id')->on('batches')->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropForeign(['batch_table_id']);
        });
    }
}
