<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_invoice_id');
            $table->string('status')->default('unpaid');
            $table->date('sent_on');
            $table->date('paid_on')->nullable();
            $table->unsignedInteger('payment_type_id');
            $table->date('due_date');
            $table->text('comments')->nullable();
            $table->string('file_path')->nullable(); // string or text?
            $table->timestamps();

            $table->foreign('payment_type_id')
                ->references('id')->on('payment_types')
                ->onDelete('cascade');
        });

        Schema::create('payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->default('wire-transfer'); // can be wire-transfer, cheque, cash etc.
            $table->string('name')->default('Wire Transfer');
            $table->timestamps();
        });

        Schema::create('invoice_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->index();
            $table->decimal('billed_amount', 10, 2);
            $table->decimal('received_amount', 10, 2)->nullable();
            $table->decimal('gst', 10, 2)->nullable();
            $table->decimal('tds', 10, 2)->nullable();
            $table->decimal('bank_charges_fund_transfer', 10, 2)->nullable();
            $table->decimal('bank_service_tax_forex', 10, 2)->nullable();
            $table->decimal('conversion_rate', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')
                ->references('id')->on('invoices')
                ->onDelete('cascade');
        });

        Schema::create('cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->string('status');
            $table->date('received_on')->nullable();
            $table->date('cleared_on')->nullable();
            $table->date('bounced_on')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')
                ->references('id')->on('invoices')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheques');
        Schema::dropIfExists('invoice_meta');
        Schema::dropIfExists('payment_types');
        Schema::dropIfExists('invoices');
    }
}
