<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStageBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_old_stage_billings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_stage_id');
            $table->float('percentage', 5, 2);
            $table->timestamps();
        });

        Schema::table('project_old_stage_billings', function (Blueprint $table) {
            $table->foreign('project_stage_id')->references('id')->on('project_old_stages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_old_stage_billings', function (Blueprint $table) {
            $table->dropForeign([
                'project_stage_id',
            ]);
        });
    }
}
