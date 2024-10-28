<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->date('proposal_sent_date')->nullable()->change();
            $table->string('domain')->nullable()->change();
            $table->string('customer_type')->nullable()->change();
            $table->text('budget')->nullable()->change();
            $table->string('proposal_status')->nullable()->change();
            $table->date('introductory_call')->nullable()->change();
            $table->date('last_followup_date')->nullable()->change();
            $table->string('rfp_link')->nullable()->change();
            $table->string('proposal_link')->nullable()->change();
            $table->string('currency')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->date('proposal_sent_date')->nullable(false)->change();
            $table->string('domain')->nullable(false)->change();
            $table->string('customer_type')->nullable(false)->change();
            $table->text('budget')->nullable(false)->change();
            $table->string('proposal_status')->nullable(false)->change();
            $table->date('introductory_call')->nullable(false)->change();
            $table->date('last_followup_date')->nullable(false)->change();
            $table->string('rfp_link')->nullable(false)->change();
            $table->string('proposal_link')->nullable(false)->change();
            $table->string('currency')->nullable(false)->change();
        });
    }
}
