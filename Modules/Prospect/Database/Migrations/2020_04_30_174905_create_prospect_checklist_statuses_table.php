<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectChecklistStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_checklist_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('module_checklist_id');
            $table->unsignedBigInteger('module_checklist_task_id');
            $table->unsignedBigInteger('prospect_id');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('prospect_checklist_statuses', function (Blueprint $table) {
            $table->foreign('module_checklist_id')->references('id')->on('module_checklists');
            $table->foreign('module_checklist_task_id')->references('id')->on('module_checklist_tasks');
            $table->foreign('prospect_id')->references('id')->on('prospects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospect_checklist_statuses', function (Blueprint $table) {
            $table->dropForeign(['module_checklist_id']);
            $table->dropForeign(['module_checklist_task_id']);
            $table->dropForeign(['prospect_id']);
        });

        Schema::dropIfExists('prospect_checklist_statuses');
    }
}
