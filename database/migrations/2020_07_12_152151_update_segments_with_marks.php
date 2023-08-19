<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSegmentsWithMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_evaluation_parameters', function (Blueprint $table) {
            $table->integer('marks');
        });

        Schema::table('hr_evaluation_parameter_options', function (Blueprint $table) {
            $table->integer('marks');
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
            $table->dropColumn('marks');
        });

        Schema::table('hr_evaluation_parameter_options', function (Blueprint $table) {
            $table->dropColumn('marks');
        });
    }
}
