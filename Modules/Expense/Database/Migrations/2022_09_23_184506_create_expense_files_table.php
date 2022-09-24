<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_files', function (Blueprint $table) {
            $table->integer('expense_id')->unsigned();
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });

        Schema::table('expense_files', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('expense_id')->references('id')->on('expenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_files');
    }
}
