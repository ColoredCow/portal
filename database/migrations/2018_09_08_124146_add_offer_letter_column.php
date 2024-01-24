<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfferLetterColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->string('offer_letter')->nullable()->after('pending_approval_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->dropColumn('offer_letter');
        });
    }
}
