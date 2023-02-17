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
        $paidInvoices = Invoice::where('status', 'paid')->get();

        foreach ($paidInvoices as $invoice) {
            InvoicePaymentsDetails::insert([
                'invoice_id' => $invoice->id,
                'amount_paid_till_now' => $invoice->amount,
                'status' => $invoice->status,
                'gst' => $invoice->gst,
                'tds' => $invoice->tds,
                'tds_percentage' => $invoice->tds_Percentage,
                'comments' => $invoice->comments,
                'last_amount_paid_on' => $invoice->receivable_date,
            ]);
        }
    }
}
