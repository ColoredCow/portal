<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prospect_id');
            $table->text('project_brief');
            $table->text('skills')->nullable();
            $table->integer('resource_required_count')->nullable();
            $table->dateTime('excepted_launch_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('prospect_requirements', function (Blueprint $table) {
            $table->foreign('prospect_id')->references('id')->on('prospects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospect_requirements', function (Blueprint $table) {
            $table->dropForeign(['prospect_id']);
        });

        Schema::dropIfExists('prospect_requirements');
    }
}
