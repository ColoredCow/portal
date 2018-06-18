<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_finance_invoices', function (Blueprint $table) {
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('finance_invoice_id');
        });

        Schema::table('project_finance_invoices', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('project_finance_invoices', function (Blueprint $table) {
            $table->dropForeign([
                'project_id',
                'finance_invoice_id',
            ]);
        });
    }
}
