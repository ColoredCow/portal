<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectHours extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type')->nullable()->after('effort_sheet_url');
            $table->float('total_estimated_hours')->nullable();
            $table->float('monthly_estimated_hours')->nullable();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['type']);
            $table->dropColumn(['total_estimated_hours']);
            $table->dropColumn(['monthly_estimated_hours']);
        });
    }
}
