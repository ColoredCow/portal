<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
