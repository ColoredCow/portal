<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinanceInvoicesPaymentTypeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->string('payment_type')->after('currency_paid_amount')->nullable();
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
            $table->dropColumn(['payment_type']);
        });
    }
}
