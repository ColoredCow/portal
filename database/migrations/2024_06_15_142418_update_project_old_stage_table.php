<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectOldStageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_old_stages', function (Blueprint $table) {
            $table->dropForeign(['project_id']);

            $table->dropColumn(['project_id', 'name', 'cost', 'currency_cost', 'type', 'cost_include_gst']);
            $table->text('comments')->nullable();
            $table->datetime('start_date')->nullable()->change();
            $table->datetime('end_date')->nullable()->change();
            $table->date('expected_end_date')->nullable()->after('end_date');
        });
        Schema::table('project_old_stages', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('id');
            $table->text('stage_name')->after('project_id');
            $table->text('status')->after('stage_name')->nullable();
            $table->Integer('duration')->after('status')->nullable();
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
        Schema::table('project_old_stages', function (Blueprint $table) {
            $table->dropColumn('comments');
            $table->dropColumn('stage_name');
            $table->dropColumn('status');
            $table->dropColumn('project_id');
            $table->dropColumn('duration');
            $table->dropColumn('expected_end_date');
        });
        Schema::table('project_old_stages', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->decimal('cost', 8, 2)->nullable();
            $table->string('currency_cost')->nullable();
            $table->string('type')->nullable();
            $table->string('cost_include_gst')->nullable();
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            $table->unsignedInteger('project_id');
        });
    }
}
