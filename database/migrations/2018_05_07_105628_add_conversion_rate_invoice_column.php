<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConversionRateInvoiceColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->decimal('conversion_rate', 10, 2)->nullable()->after('currency_paid_amount');
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
            $table->dropColumn(['conversion_rate']);
        });
    }
}
