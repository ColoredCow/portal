<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\Invoice;

class AddEncryptedCoulmsForAnalytisInInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->text('amount_for_analytics')->nullable();
            $table->text('gst_for_analytics')->nullable();
            $table->text('amount_paid_for_analytics')->nullable();
            $table->text('bank_charges_for_analytics')->nullable();
            $table->text('conversion_rate_for_analytics')->nullable();
            $table->text('conversion_rate_diff_for_analytics')->nullable();
            $table->text('tds_for_analytics')->nullable();
        });

        $invoices = Invoice::all();
        $encryptionKey = config('database.connections.mysql.encryption_key');
        foreach ($invoices as $invoice) {
            $amount = $invoice->amount;
            $gst = $invoice->gst ?? "null";
            $amountPaid = $invoice->amount_paid ?? "null";
            $bankCharges = $invoice->bank_charges ?? "null";
            $conversionRateDiff = $invoice->conversion_rate_diff ?? "null";
            $conversionRate = $invoice->conversion_rate ?? "null";
            $tds = $invoice->td ?? "null";

            DB::statement("
                UPDATE `invoices`
                SET 
                    `amount_for_analytics` = TO_BASE64(AES_ENCRYPT('{$amount}', '{$encryptionKey}')),
                    `gst_for_analytics` = TO_BASE64(AES_ENCRYPT('{$gst}', '{$encryptionKey}')),
                    `amount_paid_for_analytics` = TO_BASE64(AES_ENCRYPT('{$amountPaid}', '{$encryptionKey}')),
                    `bank_charges_for_analytics` = TO_BASE64(AES_ENCRYPT('{$bankCharges}', '{$encryptionKey}')),
                    `conversion_rate_for_analytics` = TO_BASE64(AES_ENCRYPT('{$conversionRate}', '{$encryptionKey}')),
                    `conversion_rate_diff_for_analytics` = TO_BASE64(AES_ENCRYPT('{$conversionRateDiff}', '{$encryptionKey}')),
                    `tds_for_analytics` = TO_BASE64(AES_ENCRYPT('{$tds}', '{$encryptionKey}'))
                WHERE `id` = {$invoice->id}
            ");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'amount_for_analytics',
                'gst_for_analytics',
                'amount_paid_for_analytics',
                'bank_charges_for_analytics',
                'conversion_rate_for_analytics',
                'conversion_rate_diff_for_analytics',
                'tds_for_analytics'
            ]);
        });
    }
}
