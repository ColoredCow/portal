<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryBookLocationCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_book_location', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('book_id');
            $table->unsignedBigInteger('office_location_id');
            $table->integer('number_of_copies');
            $table->timestamps();
        });

        Schema::table('library_book_location', function (Blueprint $table) {
            $table->foreign('book_id')->references('id')->on('library_books');
            $table->foreign('office_location_id')->references('id')->on('office_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('library_book_location');
    }
}
