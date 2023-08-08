<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAddressFieldsFromClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'country', 'state', 'phone', 'address', 'pincode',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('pincode')->nullable();
        });
    }
}
