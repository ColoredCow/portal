<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPendingApprovalFromInApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->unsignedInteger('pending_approval_from')->nullable()->after('status');
        });
        Schema::table('hr_applications', function (Blueprint $table) {
            $table->foreign('pending_approval_from')->references('id')->on('users');
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
            $table->dropForeign(['pending_approval_from']);
            $table->dropColumn(['pending_approval_from']);
        });
    }
}
