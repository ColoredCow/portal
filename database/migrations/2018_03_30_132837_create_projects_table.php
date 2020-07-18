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
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('client_id');
            $table->string('client_project_id')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('projects_old', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('client_project_id');
            $table->string('invoice_email')->nullable();
            $table->string('status')->default('active');
            $table->boolean('gst_applicable')->default(false);
            $table->timestamps();
        });

        Schema::table('projects_old', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_old', function (Blueprint $table) {
            $table->dropForeign([
                'client_id',
            ]);
        });

        Schema::dropIfExists('projects');
    }
}
