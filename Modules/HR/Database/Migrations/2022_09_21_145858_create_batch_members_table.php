<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->integer('employee_id')->unsigned();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_members', function (Blueprint $table) {
            $table->dropForeign([
                'employee_id',
            ]);
        });
    }
}
