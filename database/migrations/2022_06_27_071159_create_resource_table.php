<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource', function (Blueprint $table) {
            $table->id('id');
            $table->text('resource_link');
            $table->unsignedBigInteger('jobs_id');
            $table->unsignedBigInteger('resource_category');
            $table->foreign('jobs_id')->references('id')->on('hr_jobs');
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
        Schema::dropIfExists('resource');
    }
}
