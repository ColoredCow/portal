<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectNdaMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_nda_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prospect_id');
            $table->unsignedBigInteger('nda_meta_id');
            $table->timestamps();
        });

        Schema::table('prospect_nda_meta', function (Blueprint $table) {
            $table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('cascade');
            $table->foreign('nda_meta_id')->references('id')->on('nda_meta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospect_nda_meta', function (Blueprint $table) {
            $table->dropForeign(['prospect_id']);
            $table->dropForeign(['nda_meta_id']);
        });
        Schema::dropIfExists('prospect_nda_meta');
    }
}
