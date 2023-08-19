<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceChargeTaxColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->decimal('transaction_charge', 10, 2)->nullable()->after('conversion_rate');
            $table->string('currency_transaction_charge')->default('INR')->after('transaction_charge');
            $table->decimal('transaction_tax', 10, 2)->nullable()->after('currency_transaction_charge');
            $table->string('currency_transaction_tax')->default('INR')->after('transaction_tax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->dropColumn([
                'transaction_charge',
                'currency_transaction_charge',
                'transaction_tax',
                'currency_transaction_tax',
            ]);
        });
    }
}
