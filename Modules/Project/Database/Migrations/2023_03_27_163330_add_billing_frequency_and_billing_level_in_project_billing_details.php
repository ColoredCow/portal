<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingFrequencyAndBillingLevelInProjectBillingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_billing_details', function (Blueprint $table) {
            $table->string('billing_frequency');
            $table->string('billing_level')->nullable();
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
            $table->dropColumn(['billing_frequency', 'billing_level']);
        });
    }
}
