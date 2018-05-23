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
        Schema::table('hr_rounds', function(Blueprint $table) {
            $table->json('confirmation_mail_template')->nullable()->after('guidelines');
            $table->json('rejection_mail_template')->nullable()->after('confirmation_mail_template');
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
                'confirmation_mail_template',
                'rejection_mail_template'
            ]);
        });
    }
}
