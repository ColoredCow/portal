<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePaymentsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payments_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->text('amount_paid_till_now')->nullable();
            $table->string('status')->nullable();
            $table->text('bank_charges')->nullable();
            $table->text('conversion_rate')->nullable();
            $table->text('conversion_rate_diff')->nullable();
            $table->text('tds')->nullable();
            $table->text('tds_percentage')->nullable();
            $table->text('comments')->nullable();
            $table->date('last_amount_paid_on')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoice_payments_details');
    }
}
