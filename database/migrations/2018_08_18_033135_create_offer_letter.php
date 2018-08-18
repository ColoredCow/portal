<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferLetter extends Migration
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
            $table->dropColumn('offer_letter')->nullable();
        });
    }
}
