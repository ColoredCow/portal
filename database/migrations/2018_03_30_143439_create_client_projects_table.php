<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_projects', function (Blueprint $table) {
            $table->integer('client_id')->unsigned();
            $table->integer('project_id')->unsigned();
        });

        Schema::table('client_projects', function(Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->primary(['client_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_projects', function (Blueprint $table) {
            $table->dropForeign(['client_id', 'project_id']);
        });
    }
}
