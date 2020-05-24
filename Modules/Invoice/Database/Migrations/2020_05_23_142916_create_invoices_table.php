<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->string('status')->nullable();
            $table->string('currency', 3);
            $table->decimal('amount', 10, 2);
            $table->date('sent_on');
            $table->date('due_on');
            $table->decimal('gst', 10, 2)->nullable()->comment('Currency is always Indian Rupees for this field.');
            $table->text('comments')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['client_id']);
        });

        Schema::dropIfExists('invoices');
    }
}
