<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Invoice\Entities\Invoice;

class InvoicesAnalyticsEncryptedDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_analytics_encrypted_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->text('amount')->nullable();
            $table->text('gst')->nullable();
            $table->text('amount_paid')->nullable();
            $table->text('bank_charges')->nullable();
            $table->text('conversion_rate')->nullable();
            $table->text('conversion_rate_diff')->nullable();
            $table->text('tds')->nullable();
            $table->text('sent_conversion_rate')->nullable();
            $table->timestamps();
        });

        $invoices = Invoice::all();
        $encryptionKey = config('database.connections.mysql.encryption_key');
        foreach ($invoices as $invoice) {
            $amount = $invoice->amount;
            $gst = $invoice->gst ?? 'null';
            $amountPaid = $invoice->amount_paid ?? 'null';
            $bankCharges = $invoice->bank_charges ?? 'null';
            $conversionRateDiff = $invoice->conversion_rate_diff ?? 'null';
            $conversionRate = $invoice->conversion_rate ?? 'null';
            $tds = $invoice->td ?? 'null';
            $sentConversionRate = $invoice->sent_conversion_rate ?? 'null';

            DB::statement("
                INSERT INTO `invoices_analytics_encrypted_data` (
                    `invoice_id`,
                    `amount`,
                    `gst`,
                    `amount_paid`,
                    `bank_charges`,
                    `conversion_rate`,
                    `conversion_rate_diff`,
                    `tds`,
                    `sent_conversion_rate`
                )
                VALUES (
                    {$invoice->id},
                    TO_BASE64(AES_ENCRYPT('{$amount}', '{$encryptionKey}')),
                    TO_BASE64(AES_ENCRYPT('{$gst}', '{$encryptionKey}')),
                    TO_BASE64(AES_ENCRYPT('{$amountPaid}', '{$encryptionKey}')),
                    TO_BASE64(AES_ENCRYPT('{$bankCharges}', '{$encryptionKey}')),
                    TO_BASE64(AES_ENCRYPT('{$conversionRate}', '{$encryptionKey}')),
                    TO_BASE64(AES_ENCRYPT('{$conversionRateDiff}', '{$encryptionKey}')),
                    TO_BASE64(AES_ENCRYPT('{$tds}', '{$encryptionKey}')),
                    TO_BASE64(AES_ENCRYPT('{$sentConversionRate}', '{$encryptionKey}'))
                )
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
        Schema::dropIfExists('invoices_analytics_encrypted_data');
    }
}
