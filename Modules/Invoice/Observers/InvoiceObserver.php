<?php
namespace Modules\Invoice\Observers;

use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Entities\InvoicesAnalyticsEncryptedData;
use Modules\Invoice\Services\CurrencyService;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     *
     * @param  Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $conversionRates = new CurrencyService();
        $conversionRate = $conversionRates->getAllCurrentRatesInINR();
        $initial = config('invoice.currency_initials');

        switch (strtoupper($invoice->client->country->currency)) {
            case $initial['usd']:
                $invoice->sent_conversion_rate = $conversionRate['USDINR'];
                break;

            case $initial['eur']:
                $invoice->sent_conversion_rate = round(($conversionRate['USDINR']) / ($conversionRate['USDEUR']), 2);
                break;

            case $initial['swi']:
                $invoice->sent_conversion_rate = round(($conversionRate['USDINR']) / ($conversionRate['USDCHF']), 2);
                break;
        }

        $invoice->save();

        InvoicesAnalyticsEncryptedData::create([
            'invoice_id' => $invoice->id,
            'amount' => $this->encryptValue($invoice->amount),
            'gst' => $this->encryptValue($invoice->gst),
            'amount_paid' => $this->encryptValue($invoice->amount_paid),
            'bank_charges' => $this->encryptValue($invoice->bank_charges),
            'conversion_rate' => $this->encryptValue($invoice->conversion_rate),
            'conversion_rate_diff' => $this->encryptValue($invoice->conversion_rate_diff),
            'tds' => $this->encryptValue($invoice->tds),
            'sent_conversion_rate' => $this->encryptValue($invoice->sent_conversion_rate),
        ]);
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  Invoice $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        $invoiceAnalyticsEntity = InvoicesAnalyticsEncryptedData::where('invoice_id', $invoice->id)->first();

        if (! $invoiceAnalyticsEntity) {
            return;
        }

        $invoiceAnalyticsEntity->update([
            'amount' => $this->encryptValue($invoice->amount),
            'gst' => $this->encryptValue($invoice->gst),
            'amount_paid' => $this->encryptValue($invoice->amount_paid),
            'bank_charges' => $this->encryptValue($invoice->bank_charges),
            'conversion_rate' => $this->encryptValue($invoice->conversion_rate),
            'conversion_rate_diff' => $this->encryptValue($invoice->conversion_rate_diff),
            'tds' => $this->encryptValue($invoice->tds),
            'sent_conversion_rate' => $this->encryptValue($invoice->sent_conversion_rate),
        ]);
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  Invoice $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        $invoiceAnalyticsEntity = InvoicesAnalyticsEncryptedData::where('invoice_id', $invoice->id)->first();

        if (! $invoiceAnalyticsEntity) {
            return;
        }

        $invoiceAnalyticsEntity->delete();
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }

    protected function encryptValue($value)
    {
        $result = DB::select("SELECT TO_BASE64(AES_ENCRYPT('" . $value . "', '" . config('database.connections.mysql.encryption_key') . "')) AS encrypted_value");

        return $result[0]->encrypted_value;
    }
}
