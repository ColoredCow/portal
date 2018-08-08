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
        $currencies = [
            'india' => config('constants.countries.india.currency'),
        ];

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_invoice_id');
            $table->string('status')->default('unpaid');
            $table->date('sent_on');
            $table->date('paid_on')->nullable();
            $table->string('payment_type')->default('wire-transfer');
            $table->date('due_date');
            $table->text('comments')->nullable();
            $table->string('file_path')->nullable(); // string or text?
            $table->timestamps();
        });

        Schema::create('invoice_amounts', function (Blueprint $table) use ($currencies) {
            // the following fields we're capturing right now will go to this table with their currencies
            // sent amount.
            // paid amount.
            // due amount.
            // gst.
            // tds.
            // bank charges on fund transfer.
            // bank service tax on fund transfer.
            // conversion rate. does it makes sense here?

            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->string('type');
            $table->string('currency', 3)->default($currencies['india']);
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('invoice_id')
                ->references('id')->on('invoices')
                ->onDelete('cascade');
        });

        Schema::create('invoice_cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');

            $table->string('status');
            $table->date('received_date')->nullable();
            $table->date('cleared_date')->nullable();
            $table->date('bounced_date')->nullable();

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
        Schema::dropIfExists('invoice_cheques');
        Schema::dropIfExists('invoice_amounts');
        Schema::dropIfExists('invoices');
    }
}
