<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHRApplicationMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_meta', function (Blueprint $table) {
            $table->renameColumn('form_data', 'value');
            $table->string('key')->default('form-data')->after('hr_application_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_meta', function (Blueprint $table) {
            $table->renameColumn('value', 'form_data');
            $table->dropColumn(['key']);
        });
    }
}
