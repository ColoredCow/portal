<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicantAddCollege extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->string('college')->nullable()->after('resume');
            $table->string('graduation_year')->nullable()->after('resume');
            $table->string('course')->nullable()->after('resume');
            $table->string('linkedin')->nullable()->after('resume');
            $table->text('reason_for_eligibility')->nullable()->after('resume');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->dropColumn(['college', 'graduation_year', 'course', 'linkedin', 'reason_for_eligibility']);
        });
    }
}
