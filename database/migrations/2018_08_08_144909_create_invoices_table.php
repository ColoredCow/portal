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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->string('status')->nullable();
            $table->string('currency', 3);
            $table->decimal('amount', 10, 2);
            $table->date('sent_on');
            $table->date('due_on');
            $table->decimal('gst', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->text('comments')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::create('invoices_old', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_invoice_id');
            $table->string('currency', 3);
            $table->decimal('amount', 10, 2);
            $table->date('sent_on');
            $table->date('due_on');
            $table->decimal('gst', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->text('comments')->nullable();
            $table->string('file_path');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->index();
            $table->timestamp('paid_at')->useCurrent();
            $table->string('currency', 3);
            $table->decimal('amount', 10, 2);
            $table->decimal('bank_charges', 10, 2)->nullable()->comment('Has same currency as amount. Applicable to foreign transactions only.');
            $table->decimal('bank_service_tax_forex', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->decimal('tds', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->decimal('conversion_rate', 10, 2)->nullable();

            $table->unsignedInteger('mode_id');
            $table->string('mode_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')
                ->references('id')->on('invoices_old');
        });

        Schema::create('cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->date('received_on');
            $table->date('cleared_on')->nullable();
            $table->date('bounced_on')->nullable();
            $table->timestamps();
        });

        Schema::create('wire_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('via')->default('bank');
            $table->timestamps();
        });

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
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['client_id']);
        });

        Schema::dropIfExists('invoices');
        Schema::dropIfExists('cash');
        Schema::dropIfExists('wire_transfers');
        Schema::dropIfExists('cheques');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoices_old');
    }
}
