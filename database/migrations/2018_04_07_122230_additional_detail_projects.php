<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdditionalDetailProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->decimal('tds', 10, 2)->nullable()->after('currency_paid_amount');
            $table->string('currency_tds')->default('INR')->after('tds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->dropColumn([
                'tds',
                'currency_tds'
            ]);
        });
    }
}
