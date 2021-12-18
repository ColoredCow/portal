<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsCrmDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_crm_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clients_id');
            $table->foreign('clients_id')->references('id')->on('clients');
            $table->unsignedBigInteger('prospect_id')->nullable();
            $table->foreign('prospect_id')->references('id')->on('prospects');
            $table->unsignedBigInteger('client_addresses_id')->nullable();
            $table->foreign('client_addresses_id')->references('id')->on('client_addresses');
            $table->unsignedBigInteger('client_contact_persons_id')->nullable();
            $table->foreign('client_contact_persons_id')->references('id')->on('client_contact_persons');
            $table->timestamp('last_connected');
            $table->string('last_interaction')->nullable();
            $table->string('next_step')->nullable();
            $table->string('source')->nullable();
            $table->string('status');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('clients_crm_details');
    }
}
