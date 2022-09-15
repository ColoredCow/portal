<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearAndMonthColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenue_proceeds', function (Blueprint $table) {
            $table->integer('year')->after('notes');
            $table->integer('month')->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('revenue_proceeds', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });
    }
}
