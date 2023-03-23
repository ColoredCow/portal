<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingFrequencyToProjectBillingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_billing_details', function (Blueprint $table) {
            $table->unsignedTinyInteger('billing_frequency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_billing_details', function (Blueprint $table) {
            $table->dropColumn('billing_frequency');
        });
    }
}
