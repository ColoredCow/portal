<?php

namespace Modules\Invoice\Database\Factories;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Client\Entities\Client;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Services\InvoiceService;
use Modules\Project\Entities\Project;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $projectId = null;
        $billingLevels = null;
        $amount = 0;
        $gst = null;
        $bankCharges = null;
        $tds = null;
        $tdsPercentage = null;
        $activeClient = null;

        $invoice_status = ['sent', 'paid'];
        $status_key = array_rand($invoice_status, 1);
        $status = $invoice_status[$status_key];

        $billingLevels = ['client', 'project'];
        $invoiceBillingKey = array_rand($billingLevels, 1);
        $billingLevel = $billingLevels[$invoiceBillingKey];

        if ($billingLevel === 'client') {
            $activeClient = Client::where('status', 'active')->inRandomOrder()->pluck('id')->first();
        } else {
            $project = Project::where('status', 'active')->inRandomOrder()->first();
            $projectId = $project->id;
            $activeClient = $project->client_id;
        }

        $currency = Country::inRandomOrder()->pluck('currency')->first();
        $amount = 0;

        if ($currency === 'INR') {
            $amount = rand(50000, 300000);
            $roundedAmount = intval(ceil($amount / 1000) * 1000);
            $roundedAmountFloat = floatval($roundedAmount);
            $gst = intval(ceil($roundedAmountFloat * 0.18));
            $tds = intval(ceil($roundedAmountFloat * 0.10));
            $tdsPercentage = 10;
        } else {
            $amount = rand(1000, 5000);
            $roundedAmount = intval(ceil($amount / 100) * 100);
            $roundedAmountFloat = floatval($roundedAmount);
            $bankCharges = intval(ceil($roundedAmountFloat * 0.05));
        }

        $sentOn = now()->format('Y-m-d');
        $dueOn = date('Y-m-d', strtotime($sentOn . ' + 7 days'));
        $previousDay = Carbon::parse($sentOn)->subDay();
        $previousMonth = $previousDay->subMonth();

        $termStartDate = $previousMonth->format('Y-m-d');
        $termEndDate = Carbon::yesterday()->format('Y-m-d');

        $invoiceService = new InvoiceService();
        $invoiceNumber = $invoiceService->getInvoiceNumber($activeClient, $projectId, $sentOn, $billingLevel);

        return [
            'client_id' => $activeClient,
            'project_id' => $projectId,
            'status' => $status,
            'billing_level' => $billingLevel,
            'currency' => $currency,
            'amount' => $roundedAmount,
            'sent_on' => $sentOn,
            'due_on' => $dueOn,
            'receivable_date' => $dueOn,
            'gst' => $gst,
            'file_path' => 'invoice/2022/06/IN1260010000020522.pdf',
            'comments' => '',
            'amount_paid' => $roundedAmount,
            'bank_charges' => $bankCharges,
            // 'conversion_rate_diff' => '',
            // 'conversion_rate' => '',
            'tds' => $tds,
            'tds_percentage' => $tdsPercentage,
            'currency_transaction_charge' => $currency,
            'payment_at' => $dueOn,
            'invoice_number' => $invoiceNumber,
            'reminder_mail_count' => 0,
            'payment_confirmation_mail_sent' => 0,
            'term_start_date' => $termStartDate,
            'term_end_date' => $termEndDate,
        ];
    }
}
