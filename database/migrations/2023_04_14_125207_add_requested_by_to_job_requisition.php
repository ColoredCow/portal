<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestedByToJobRequisition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_requisition', function (Blueprint $table) {
            $table->unsignedInteger('requested_by');
            $table->foreign('requested_by')->references('id')->on('users');
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
            $table->dropForeign('requested_by');
            $table->dropColumn('requested_by');
        });
    }
}
