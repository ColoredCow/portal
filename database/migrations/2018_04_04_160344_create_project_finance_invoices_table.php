<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_old_finance_invoices', function (Blueprint $table) {
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('finance_invoice_id');
        });

        Schema::table('project_old_finance_invoices', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects_old');
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
        Schema::dropIfExists('project_old_finance_invoices', function (Blueprint $table) {
            $table->dropForeign([
                'project_id',
                'finance_invoice_id',
            ]);
        });
    }
}
