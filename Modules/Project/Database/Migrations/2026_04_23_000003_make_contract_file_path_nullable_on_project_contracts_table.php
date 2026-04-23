<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeContractFilePathNullableOnProjectContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->string('contract_file_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->string('contract_file_path')->nullable(false)->change();
        });
    }
}
