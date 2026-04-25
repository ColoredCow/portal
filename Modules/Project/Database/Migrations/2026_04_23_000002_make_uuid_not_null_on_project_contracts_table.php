<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUuidNotNullOnProjectContractsTable extends Migration
{
    public function up()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('project_contracts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->change();
        });
    }
}
