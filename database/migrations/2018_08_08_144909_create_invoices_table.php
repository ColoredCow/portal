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
            $table->string('status')->default('unpaid'); // Create a model event to update this value when a new payment is created for this invoice.
            $table->string('currency', 3);
            $table->decimal('amount', 10, 2);
            $table->date('sent_on');
            $table->date('due_on'); // Calculation at the time of creating invoice. Maybe 15 days after. Should be configurable from application.
            $table->decimal('gst', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->text('comments')->nullable();
            $table->string('file_path');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->index();
            $table->date('paid_on'); // add default to current timestamp
            $table->string('currency', 3);
            $table->decimal('amount', 10, 2);
            $table->decimal('bank_charges', 10, 2)->nullable()->comment('Has same currency as amount'); // not applicable for local transactions.
            $table->decimal('bank_service_tax_forex', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->decimal('tds', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->decimal('conversion_rate', 10, 2)->nullable();

            $table->unsignedInteger('mode_id');
            $table->string('mode_type'); // polymorphic relation
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')
                ->references('id')->on('invoices');
        });

        Schema::create('cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->date('received_on')->nullable(); // check when is this added.
            $table->date('cleared_on')->nullable(); // check when is this added. until cleared, it shouldn't be added to the income.
            $table->date('bounced_on')->nullable(); // what will happen if a check is bounced? complimentary to cleared.
            $table->timestamps();
        });

        Schema::create('wire_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('via')->default('bank'); // bank, paypal, western-union etc.
            $table->timestamps();
        });

        // does not have any attributes right now
        Schema::create('cash', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::dropIfExists('cash');
        Schema::dropIfExists('wire_transfers');
        Schema::dropIfExists('cheques');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoices');
    }
}
