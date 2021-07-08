<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNextInterviewCommentsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_application_segments', function (Blueprint $table) {
            $table->renameColumn('next_interview_comments', 'comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_application_segments', function (Blueprint $table) {
            $table->renameColumn('comments', 'next_interview_comments');
        });
    }
}
