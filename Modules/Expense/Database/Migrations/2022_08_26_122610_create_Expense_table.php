<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Expense', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('amount');
            $table->string('status')->nullable();
            $table->string('paid_on')->nullable();
            $table->string('category');
            $table->string('location')->nullable();
            $table->string('uploaded_by');
            $table->string('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Expense');
    }
}
