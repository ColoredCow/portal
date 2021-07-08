<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientBillingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_billing_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->string('service_rates')->nullable();
            $table->string('service_rate_term')->nullable();
            $table->string('discount_rate')->nullable();
            $table->string('discount_rate_term')->nullable();
            $table->string('billing_frequency')->nullable();
            $table->string('bank_charges')->nullable();
            $table->string('currency')->nullable();
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
        Schema::dropIfExists('client_billing_details');
    }
}
