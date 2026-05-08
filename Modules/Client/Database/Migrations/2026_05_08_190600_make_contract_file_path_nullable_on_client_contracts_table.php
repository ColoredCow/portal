<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeContractFilePathNullableOnClientContractsTable extends Migration
{
    public function up()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
            $table->string('contract_file_path')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('client_contracts', function (Blueprint $table) {
            $table->string('contract_file_path')->nullable(false)->change();
        });
    }
}
