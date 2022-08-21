<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PhotoGallaryMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_gallery_meta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photo_gallery_id');
            $table->string('resolution');
            $table->string('iso')->nullable();
            $table->string('format');
            $table->timestamps();
            $table->softDeletes()->nullable();
            $table->foreign('photo_gallery_id')->references('id')->on('photo_gallery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_gallery_meta');
    }
}
