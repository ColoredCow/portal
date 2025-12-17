<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleChecklistTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_checklist_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('module_checklist_id');
            $table->string('slug');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('module_checklist_tasks', function (Blueprint $table) {
            $table->foreign('module_checklist_id')->references('id')->on('module_checklists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module_checklist_tasks', function (Blueprint $table) {
            $table->dropForeign(['module_checklist_id']);
        });

        Schema::dropIfExists('module_checklist_tasks');
    }
}
