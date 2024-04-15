<?php

namespace Modules\Invoice\Observers;

use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Services\CurrencyService;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     *
     * @param  \Modules\Invoice\Entities\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $conversionRates = new CurrencyService();
        $conversionRate = $conversionRates->getAllSCurrentRatesInINR();
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

    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \Modules\Invoice\Entities\Invoice $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \Modules\Invoice\Entities\Invoice $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \Modules\Invoice\Entities\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \Modules\Invoice\Entities\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
