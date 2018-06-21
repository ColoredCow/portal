<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('client_project_id');
            $table->date('started_on')->nullable();
            $table->string('invoice_email')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects', function (Blueprint $table) {
            $table->dropForeign([
                'client_id',
            ]);
        });
    }
}
