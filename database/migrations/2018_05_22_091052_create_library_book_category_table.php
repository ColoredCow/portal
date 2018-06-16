<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibraryBookCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_book_category', function (Blueprint $table) {
            $table->integer('book_category_id')->unsigned();
            $table->integer('library_book_id')->unsigned();
        });

        Schema::table('library_book_category', function (Blueprint $table) {
            $table->foreign('book_category_id')->references('id')->on('book_categories');
            $table->foreign('library_book_id')->references('id')->on('library_books');
            $table->primary(['book_category_id', 'library_book_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('library_book_category');
    }
}
