<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectStageFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_stages', function (Blueprint $table) {
            $table->string('type')->nullable()->after('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['started_on', 'end_date', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->date('started_on')->nullable();
            $table->date('end_date')->nullable();
        });

        Schema::table('project_stages', function (Blueprint $table) {
            $table->dropColumn(['type', 'end_date', 'start_date']);
        });
    }
}
