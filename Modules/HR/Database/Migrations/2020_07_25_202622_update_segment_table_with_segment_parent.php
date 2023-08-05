<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSegmentTableWithSegmentParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_evaluation_parameters', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->after('name')->nullable();
            $table->unsignedInteger('parent_option_id')->after('parent_id')->nullable();
        });

        Schema::table('hr_evaluation_parameters', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('hr_evaluation_parameters');
            $table->foreign('parent_option_id')->references('id')->on('hr_evaluation_parameter_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_evaluation_parameters', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['parent_option_id']);
            $table->dropColumn(['parent_id', 'parent_option_id']);
        });
    }
}
