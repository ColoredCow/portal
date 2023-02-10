<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeTrekApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_trek_applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable();
            $table->string('email')->nullable(false);
            $table->string('github_user_name')->nullable(false);
            $table->string('phone')->nullable();
            $table->string('status')->nullable()->default('active')->nullable(false);
            $table->string('course')->nullable();
            $table->date('start_date')->nullable(false);
            $table->integer('graduation_year')->nullable();
            $table->string('university')->nullable();
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
        Schema::dropIfExists('code_trek_applicants');
    }
}
