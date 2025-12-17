<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHrUniversityIdToHrApplicantsTable extends Migration
{
    public function up()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->foreignId('hr_university_id')->nullable()->constrained('hr_universities');
        });
    }

    public function down()
    {
        Schema::table('hr_applicants', function (Blueprint $table) {
            $table->dropForeign(['hr_university_id']);
            $table->dropColumn('hr_university_id');
        });
    }
}
