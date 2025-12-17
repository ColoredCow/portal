<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BillingInvoicesManyToOneMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_old_stage_billings', function (Blueprint $table) {
            $table->unsignedInteger('finance_invoice_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_old_stage_billings', function (Blueprint $table) {
            $table->dropColumn('finance_invoice_id');
        });
    }
}
