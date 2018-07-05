<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->string('currency_transaction_charge')->nullable()->change();
            $table->string('currency_transaction_tax')->nullable()->change();
            $table->string('currency_due_amount')->nullable()->change();
        }); //
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
                'currency_transaction_charge',
                'currency_transaction_tax',
                'currency_due_amount',
            ]);
        });
    }
}
