<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_meta', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->string('key');
            $table->string('value')->nullable();
            $table->timestamps();
            $table->foreign('project_id')->references('id')->on('projects');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_meta');
    }
}
