<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrRoundsAddRoundMailTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_rounds', function (Blueprint $table) {
            $table->json('confirmed_mail_template')->nullable()->after('guidelines');
            $table->json('rejected_mail_template')->nullable()->after('confirmed_mail_template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_rounds', function (Blueprint $table) {
            $table->dropColumn([
                'confirmed_mail_template',
                'rejected_mail_template'
            ]);
        });
    }
}
