<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResourcesHasVariableRatesToProjectBillingDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_billing_details', function (Blueprint $table) {
            $table->boolean('resources_has_variable_rates')->default(false);
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
            $table->dropColumn(['resources_has_variable_rates']);
        });
    }
}
