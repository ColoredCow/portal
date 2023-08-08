<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewInternalContractReviewerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_internal_reviewer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->string('name');
            $table->string('email');
            $table->integer('user_id')->unsigned();
            $table->string('status');
            $table->string('user_type');
            $table->timestamps();
            $table->foreign('contract_id')->references('id')->on('contracts');
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
        Schema::dropIfExists('contract_internal_reviewer', function (Blueprint $table) {
            $table->dropForeign([
                'contract_id',
                'user_id',
            ]);
        });
    }
}
