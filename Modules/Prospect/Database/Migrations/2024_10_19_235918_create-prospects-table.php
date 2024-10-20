<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            
            $table->integer('poc_user_id')->unsigned();
            
            $table->date('proposal_sent_date');
            $table->string('domain');
            $table->string('customer_type');
            $table->decimal('budget', 15, 2);
            $table->string('proposal_status');
            $table->date('introductory_call')->nullable();
            $table->date('last_followup_date')->nullable();
            $table->string('rfp_link');
            $table->string('proposal_link');
            
            $table->foreign('poc_user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospects');
    }
}
