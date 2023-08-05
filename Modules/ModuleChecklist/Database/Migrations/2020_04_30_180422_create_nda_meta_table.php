<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdaMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nda_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('approver_id');
            $table->unsignedInteger('authoriser_id');
            $table->string('status');
            $table->bigInteger('mail_template_id');
            $table->bigInteger('nda_template_id');
            $table->text('nda_contact_persons');
            $table->date('due_date');
            $table->boolean('enable_reminder')->default(true);
            $table->timestamps();
        });

        Schema::table('nda_meta', function (Blueprint $table) {
            $table->foreign('approver_id')->references('id')->on('users');
            $table->foreign('authoriser_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nda_meta', function (Blueprint $table) {
            $table->dropForeign(['approver_id']);
            $table->dropForeign(['authoriser_id']);
        });

        Schema::dropIfExists('nda_meta');
    }
}
