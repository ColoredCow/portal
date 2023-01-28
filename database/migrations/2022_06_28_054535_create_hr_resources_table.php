<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->text('resource_link');
            $table->integer('hr_resource_category_id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->timestamps();
            $table->foreign('hr_resource_category_id')->references('id')->on('hr_resources_categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('job_id')->references('id')->on('hr_jobs')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_resources');
    }
}
