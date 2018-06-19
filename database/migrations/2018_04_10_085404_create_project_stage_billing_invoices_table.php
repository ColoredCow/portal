<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectStageBillingInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_stage_billing_invoices', function (Blueprint $table) {
            $table->unsignedInteger('project_stage_billing_id');
            $table->unsignedInteger('finance_invoice_id');
        });

        Schema::table('project_stage_billing_invoices', function (Blueprint $table) {
            $table->foreign('project_stage_billing_id')->references('id')->on('project_stage_billings');
            $table->foreign('finance_invoice_id')->references('id')->on('finance_invoices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_stage_billing_invoices', function (Blueprint $table) {
            $table->dropForeign([
                'project_stage_billing_id',
                'finance_invoice_id',
            ]);
        });
    }
}
