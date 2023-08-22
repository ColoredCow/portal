<?php

namespace Modules\Invoice\Database\Factories;

use Modules\Invoice\Entities\Invoice;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use App\Models\Country;
use Carbon\Carbon;
use Modules\Invoice\Services\InvoiceService;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $project_id = null;
        $billing_level =null;
        $amount = 0;
        $gst = null;
        $bankCharges = null;
        $tds =null;
        $tdsPercentage = null;

        $active_client = Client::where('status', 'active')->inRandomOrder()->pluck('id')->first();

        $invoice_status = array("sent", "paid");
        $status_key = array_rand($invoice_status, 1);
        $status = $invoice_status[$status_key];

        $billing_level = array("client", "project");
        $invoice_billing_key = array_rand($billing_level,1);
        $billingLevel = $billing_level[$invoice_billing_key];


        if ($active_client) {
            $project = Project::where('client_id', $active_client)->first();
            $project_id = $project ? $project->id : null;
        } else {
            $project_id = null;
        }

        $currency = Country::inRandomOrder()->pluck('currency')->first();
        $amount = 0;
        $min = ceil(50000 / 1000) * 1000;
        $max = floor(300000 / 1000) * 1000;


        if($currency === "INR"){
          $amount = rand(50000, 300000);
          $roundedAmount = (intval(ceil($amount / 1000) * 1000));
          $roundedAmountFloat = floatval($roundedAmount);
          $gst = intval(ceil($roundedAmountFloat * 0.18));
          $tds = intval(ceil($roundedAmountFloat*0.10));
          $tdsPercentage = 10;
        }else{
          $amount = rand(1000,5000);
          $roundedAmount =(intval(ceil($amount / 100) * 100));
          $roundedAmountFloat = floatval($roundedAmount);
          $bankCharges = intval(ceil($roundedAmountFloat*0.05));
        }

        $sent_on = now()->format('Y-m-d');
        $due_on = date('Y-m-d', strtotime($sent_on. ' + 7 days'));
        $one_day_ago = Carbon::parse($sent_on)->subDay();
        $one_month_ago = $one_day_ago->subMonth();

        $term_start_date = $one_month_ago->format('Y-m-d');
        $term_end_date = Carbon::yesterday()->format('Y-m-d');

        $invoiceService = new InvoiceService();
        $invoiceNumber = $invoiceService->getInvoiceNumber($active_client, $project_id, $sent_on, $billing_level);

        return [
            'client_id' => $active_client,
            'project_id' => $project_id,
            'status' => $status,
            'billing_level' => $billingLevel,
            'currency' => $currency,
            'amount' => $roundedAmount,
            'sent_on' => $sent_on,
            'due_on' => $due_on,
            'receivable_date' => $due_on,
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
            'payment_at' => $due_on,
            'invoice_number' => $invoiceNumber,
            'reminder_mail_count' => 0,
            'payment_confirmation_mail_sent' => 0,
            'term_start_date' => $term_start_date,
            'term_end_date' => $term_end_date,
        ];
    }
}
