<?php

namespace Database\Seeders;

use App\Models\Finance\Invoice;
use App\Models\Finance\Payment;
use App\Models\ProjectStageBilling;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateFinanceInvoiceToInvoice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoices = DB::table('finance_invoices')->get();
        foreach ($invoices as $invoice) {
            $newInvoice = self::migrateInvoice($invoice);

            if ($invoice->status == 'paid') {
                self::createPayment($invoice);
            }
        }

        self::migrateBillings();
    }

    protected static function migrateInvoice($invoice)
    {
        $invoiceAttr = [
            'id' => $invoice->id,
            'project_invoice_id' => $invoice->project_invoice_id,
            'currency' => $invoice->currency_sent_amount,
            'amount' => $invoice->sent_amount,
            'sent_on' => $invoice->sent_on,
            'gst' => $invoice->gst,
            'comments' => $invoice->comments,
            'file_path' => $invoice->file_path,
            'created_at' => $invoice->created_at,
            'updated_at' => $invoice->updated_at,
        ];
        if (is_null($invoice->due_date)) {
            $invoiceAttr['due_on'] = Carbon::parse($invoice->sent_on)->addDays('10')->format('Y-m-d');
        } else {
            $invoiceAttr['due_on'] = $invoice->due_date;
        }

        return Invoice::create($invoiceAttr);
    }

    protected static function createPayment($invoice)
    {
        $mode = self::createPaymentMode($invoice);

        $model = config('constants.finance.payments.modes.' . $mode->type);
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'paid_at' => $invoice->paid_on,
            'currency' => $invoice->currency_paid_amount,
            'amount' => $invoice->paid_amount,
            'bank_charges' => $invoice->transaction_charge,
            'bank_service_tax_forex' => $invoice->transaction_tax,
            'tds' => $invoice->tds,
            'conversion_rate_diff' => $invoice->conversion_rate_diff,
            'mode_id' => $mode->id,
            'mode_type' => $model,
            'created_at' => $invoice->created_at,
            'updated_at' => $invoice->updated_at,
        ]);
    }

    protected static function createPaymentMode($invoice)
    {
        $modeAttr = [];
        switch ($invoice->payment_type) {
            case 'cheque':
                $modeAttr['status'] = $invoice->cheque_status;
                if (is_null($invoice->cheque_received_date)) {
                    $modeAttr['received_on'] = $invoice->paid_on;
                } else {
                    $modeAttr['received_on'] = $invoice->cheque_received_date;
                }
                $modeAttr['cleared_on'] = $invoice->cheque_cleared_date;
                $modeAttr['bounced_on'] = $invoice->cheque_bounced_date;
                break;
        }
        $model = config('constants.finance.payments.modes.' . $invoice->payment_type);

        return $model::create($modeAttr);
    }

    protected static function migrateBillings()
    {
        $billings = ProjectStageBilling::all();
        foreach ($billings as $billing) {
            $billing->update([
                'invoice_id' => $billing->finance_invoice_id,
            ]);
        }
    }
}
