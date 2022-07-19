<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('invoice_id');
            $table->text('body')->nullable();
            $table->text('subject')->nullable();
            $table->string('type');
            $table->timestamp('sent_on');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
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
        Schema::dropIfExists('invoice_mails');
    }
}
