<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdditionalDetailProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type')->nullable()->after('status');
            $table->date('end_date')->nullable()->after('type');
            $table->boolean('gst_applicable')->default(false)->after('end_date');
        });

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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'end_date',
                'gst_applicable',
            ]);
        });
        Schema::table('finance_invoices', function (Blueprint $table) {
            $table->dropColumn([
                'tds',
                'currency_tds',
            ]);
        });
    }
}
