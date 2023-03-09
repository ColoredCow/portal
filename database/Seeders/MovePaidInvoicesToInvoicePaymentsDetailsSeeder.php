<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Invoice\Entities\Invoice;
use App\Models\InvoicePaymentsDetails;

class MovePaidInvoicesToInvoicePaymentsDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paidInvoices = Invoice::whereNotNull('amount_paid')->get();

        foreach ($paidInvoices as $invoice) {
            InvoicePaymentsDetails::create([
                'invoice_id' => $invoice->id,
                'amount_paid' => $invoice->amount_paid,
                'bank_charges' => $invoice->bank_charges ?? null,
                'tds' => $invoice->tds ?? null,
                'tds_percentage' => $invoice->tds_percentage ?? null,
                'conversion_rate' => $invoice->conversion_rate ?? null,
                'conversion_rate_diff' => $invoice->conversion_rate_diff ?? null,
                'comments' => $invoice->comments,
                'amount_paid_on' => $invoice->receivable_date,
            ]);
        }
    }
}
