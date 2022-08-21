<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PhotoGallaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('photo_gallery', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('event_name');
        //     $table->string('img_url');
        //     $table->integer('uploaded_by')->unsigned();
        //     $table->timestamps();
        //     $table->softDeletes()->nullable();
        //     $table->longText('description')->nullable();
        //     $table->foreign('uploaded_by')->references('id')->on('users');
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->longText('content');
            $table->string('image');
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
        // Schema::dropIfExists('photo_gallery');
        Schema::dropIfExists('posts');
    }
}
