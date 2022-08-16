<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->foreign('module_checklist_id')->references('id')->on('module_checklists')->onDelete('cascade');
            $table->foreign('module_checklist_task_id')->references('id')->on('module_checklist_tasks')->onDelete('cascade');
            $table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('cascade');
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
