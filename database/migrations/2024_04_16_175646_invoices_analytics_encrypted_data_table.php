<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoicesAnalyticsEncryptedDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_analytics_encrypted_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->text('amount')->nullable();
            $table->text('gst')->nullable();
            $table->text('amount_paid')->nullable();
            $table->text('bank_charges')->nullable();
            $table->text('conversion_rate_diff')->nullable();
            $table->text('tds')->nullable();
            $table->text('sent_conversion_rate')->nullable();
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
        Schema::dropIfExists('invoices_analytics_encrypted_data');
    }
}
