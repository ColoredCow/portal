<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->string('label');
            $table->string('percentage_rate')->nullable();
            $table->string('percentage_applied_on')->nullable();
            $table->string('fixed_amount')->nullable();
            $table->string('type')->default('dynamic');
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
        Schema::dropIfExists('salary_configurations');
    }
}
