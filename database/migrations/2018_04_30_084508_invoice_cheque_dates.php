<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoiceChequeDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->date('cheque_received_date')->nullable()->after('cheque_status');
            $table->date('cheque_cleared_date')->nullable()->after('cheque_received_date');
            $table->date('cheque_bounced_date')->nullable()->after('cheque_cleared_date');
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
            $table->dropColumn(['cheque_received_date', 'cheque_cleared_date', 'cheque_bounced_date']);
        });
    }
}
