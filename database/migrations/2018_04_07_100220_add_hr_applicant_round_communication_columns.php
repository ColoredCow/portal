<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHrApplicantRoundCommunicationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applicants_rounds', function (Blueprint $table) {
            $table->boolean('mail_sent')->default(false);
            $table->string('mail_subject')->nullable();
            $table->text('mail_body')->nullable();
            $table->unsignedInteger('mail_sender')->nullable();
            $table->timestamp('mail_sent_at')->nullable();
            $table->foreign('mail_sender')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_applicants_rounds', function (Blueprint $table) {
            $table->dropForeign(['mail_sender']);
            $table->dropColumn(['mail_sent', 'mail_subject', 'mail_body', 'mail_sender', 'mail_sent_at']);
        });
    }
}
