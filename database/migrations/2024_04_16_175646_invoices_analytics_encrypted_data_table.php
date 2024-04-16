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
            $table->string('currency', 3);
            $table->text('amount');
            $table->string('gst')->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->text('bank_charges');
            $table->text('conversion_rate_diff');
            $table->text('tds');
            $table->text('sent_conversion_rate');
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
