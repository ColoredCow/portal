<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_old_stages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->string('name');
            $table->decimal('cost', 10, 2);
            $table->string('currency_cost')->default('USD');
            $table->boolean('cost_include_gst')->default(false);
            $table->timestamps();
        });

        Schema::table('project_old_stages', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_old_stages', function (Blueprint $table) {
            $table->dropForeign([
                'project_id',
            ]);
        });
    }
}
