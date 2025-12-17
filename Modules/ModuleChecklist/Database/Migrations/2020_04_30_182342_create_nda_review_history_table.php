<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdaReviewHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nda_review_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nda_meta_id');
            $table->unsignedInteger('approver_id');
            $table->string('action');
            $table->text('reason');
            $table->timestamps();
        });

        Schema::table('nda_review_history', function (Blueprint $table) {
            $table->foreign('nda_meta_id')->references('id')->on('nda_meta');
            $table->foreign('approver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nda_review_history', function (Blueprint $table) {
            $table->dropForeign(['nda_meta_id']);
            $table->dropForeign(['approver_id']);
        });

        Schema::dropIfExists('nda_review_history');
    }
}
