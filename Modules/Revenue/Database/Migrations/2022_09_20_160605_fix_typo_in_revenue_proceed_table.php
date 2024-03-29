<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixTypoInRevenueProceedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenue_proceeds', function (Blueprint $table) {
            $table->renameColumn('recieved_at', 'received_at');
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
            $table->renameColumn('received_at', 'recieved_at');
        });
    }
}
