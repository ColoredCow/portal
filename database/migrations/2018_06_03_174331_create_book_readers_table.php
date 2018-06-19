<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookReadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_readers', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('library_book_id')->unsigned();
        });

        Schema::table('book_readers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('library_book_id')->references('id')->on('library_books');
            $table->primary(['user_id', 'library_book_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_readers');
    }
}
