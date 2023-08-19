<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesClientCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_client_characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_client_id')->constrained();
            $table->foreignId('sales_area_char_id')->constrained('sales_area_characteristics');
            $table->text('value');
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
        Schema::dropIfExists('sales_client_characteristics');
    }
}
