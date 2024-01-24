<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProspectTableWithComingFromId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->bigInteger('coming_from_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->dropColumn('coming_from_id');
        });
    }
}
