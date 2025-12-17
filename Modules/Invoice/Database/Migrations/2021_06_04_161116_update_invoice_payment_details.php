<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicePaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->text('amount_paid')->nullable();
            $table->text('bank_charges')->nullable();
            $table->text('conversion_rate')->nullable();
            $table->text('tds')->nullable();
            $table->text('tds_percentage')->nullable();
            $table->text('currency_transaction_charge')->nullable();
            $table->date('payment_at')->nullable();
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
            $table->dropColumn(['amount_paid', 'bank_charges', 'conversion_rate', 'tds', 'tds_percentage', 'currency_transaction_charge', 'payment_at']);
        });
    }
}
