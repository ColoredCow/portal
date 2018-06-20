<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('project_invoice_id');
            $table->string('status')->default('unpaid');
            $table->date('sent_on')->nullable();
            $table->date('paid_on')->nullable();
            $table->text('comments')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_invoices', function (Blueprint $table) {
            $table->dropForeign([
                'project_id',
            ]);
        });
    }
}
