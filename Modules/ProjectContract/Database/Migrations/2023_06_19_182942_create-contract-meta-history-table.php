<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractMetaHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_meta_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('review_id');
            $table->string('key');
            $table->string('value');
            $table->boolean('has_changed')->default(false);
            $table->timestamps();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('review_id')->references('id')->on('contract_review');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_meta_history', function (Blueprint $table) {
            $table->dropForeign([
                'contract_id',
                'review_id'
            ]);
        });
    }
}
