<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHrApplicationMetaReasonForEligibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_meta', function (Blueprint $table) {
            $table->text('reason_for_eligibility')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_meta', function (Blueprint $table) {
            $table->dropColumn(['reason_for_eligibility']);
        });
    }
}
