<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUuidNotNullOnClientContractsTable extends Migration
{
    public function up()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->change();
        });
    }
}
