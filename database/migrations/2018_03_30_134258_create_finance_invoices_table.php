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
            $table->string('name');
            $table->integer('project_id')->unsigned();
            $table->string('status')->default('unpaid');
            $table->timestamp('sent_on')->nullable();
            $table->timestamp('paid_on')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        Schema::table('finance_invoices', function(Blueprint $table) {
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
