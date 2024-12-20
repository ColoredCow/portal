<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RemoveProspectsReletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('prospect_contact_persons');
        Schema::dropIfExists('prospect_documents');
        Schema::dropIfExists('prospect_histories');
        Schema::dropIfExists('prospect_agreements');
        Schema::dropIfExists('prospect_checklist_meta');
        Schema::dropIfExists('prospect_checklist_statuses');
        Schema::dropIfExists('prospect_nda_meta');
        Schema::dropIfExists('prospect_requirements');
        Schema::dropIfExists('prospect_calendar_meeting');
        Schema::dropIfExists('prospect_stages');
        Schema::dropIfExists('client_crm_details');
        Schema::dropIfExists('prospects');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No action needed since we don't recreate the table
    }
}
