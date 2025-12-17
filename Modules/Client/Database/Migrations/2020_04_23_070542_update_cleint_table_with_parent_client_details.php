<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCleintTableWithParentClientDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('is_channel_partner')->default(false);
            $table->boolean('has_departments')->default(false);
            $table->bigInteger('channel_partner_id')->nullable();
            $table->bigInteger('parent_organisation_id')->nullable()->comment('It will be a reference to client table when the child client is a department of the parent client.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['is_channel_partner', 'has_departments', 'channel_partner_id', 'parent_organisation_id']);
        });
    }
}
