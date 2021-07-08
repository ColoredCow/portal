<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->decimal('estimated_effort', 3, 1);
            $table->decimal('effort_spent', 3, 1);
            $table->date('worked_on');
            $table->unsignedInteger('asignee_id');
            $table->unsignedBigInteger('project_id');
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->foreign('asignee_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
