<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesAreaCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_area_characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_area_id')->constrained();
            $table->string('name');
            $table->string('type');
            $table->string('operator');
            $table->string('value');
            $table->boolean('is_optional')->default(true);
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
        Schema::dropIfExists('sales_area_characteristics');
    }
}
