<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientEmailsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('email', 'emails');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->text('emails')->change();
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
            $table->renameColumn('emails', 'email');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->string('email')->change();
        });
    }
}
