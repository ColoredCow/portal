<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->decimal('sent_amount', 10, 2)->after('sent_on');
            $table->string('currency_sent_amount')->default('USD')->after('sent_amount');
            $table->decimal('paid_amount', 10, 2)->nullable()->after('paid_on');
            $table->string('currency_paid_amount')->nullable()->after('paid_amount');
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
            $table->dropColumn(['sent_amount', 'currency_sent_amount', 'paid_amount', 'currency_paid_amount']);
        });
    }
}
