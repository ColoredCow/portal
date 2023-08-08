<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectChecklistMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_checklist_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('prospect_id');
            $table->bigInteger('checklist_id');
            $table->bigInteger('checklist_task_id');
            $table->string('meta_key');
            $table->text('meta_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospect_checklist_meta');
    }
}
