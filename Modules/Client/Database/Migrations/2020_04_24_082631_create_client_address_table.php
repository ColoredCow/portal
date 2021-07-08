<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->bigInteger('country_id');
            $table->string('state')->nullable();
            $table->string('gst_number')->nullable();
            $table->text('address')->nullable();
            $table->string('area_code')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_addresses');
    }
}
