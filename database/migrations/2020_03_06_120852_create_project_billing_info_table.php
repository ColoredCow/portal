<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectBillingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_billing_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id');
            $table->text('contact_person_name')->nullable();
            $table->text('contact_person_email')->nullable();
            $table->text('other_members_to_cc')->nullable();
            $table->text('address')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('gst_number')->nullable();
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
        Schema::dropIfExists('project_billing_info');
    }
}
