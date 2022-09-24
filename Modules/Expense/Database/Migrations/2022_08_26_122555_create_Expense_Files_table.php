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
            $table->bigIncrements('expense_id');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedInteger('user_id');
        });

        Schema::table('expense_files', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
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
