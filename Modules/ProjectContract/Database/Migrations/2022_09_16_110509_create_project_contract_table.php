<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_contract_meta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('website_url');
            $table->string('logo_img');
            $table->string('authority_name')->nullable();
            $table->string('contract_date_for_signing');
            $table->string('contract_date_for_effective');
            $table->string('contract_expiry_date');
            $table->json('attributes')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_contract_meta', function (Blueprint $table) {
            $table->dropForeign([
                'client_id',
            ]);
        });
    }
}
