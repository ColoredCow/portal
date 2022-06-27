<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->text('resource_link');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('resource_category');
            $table->foreign('job_id')->references('id')->on('hr_jobs');
            $table->foreign('resource_category')->references('id')->on('resources_categories');
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
        Schema::dropIfExists('resources');
    }
}
