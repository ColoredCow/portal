<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHrApplicantsTable extends Migration
{
    public function up()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->timestamp('wa_optin_at')->after('phone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->dropColumn(['wa_optin_at']);
        });
    }
}
