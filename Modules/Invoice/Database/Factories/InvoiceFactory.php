<?php

namespace Modules\HR\Database\Factories;

use Modules\Invoice\Entities\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicantsFactory extends Factory
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

      $billingLevel = array_rand(['client', 'project']);
      $client = null;
      $project = null;
      if ($billingLevel == 'client') {
        $client = Client::random()->where('status', 'active');
      } else {
        $project = Project::random()->where('status', 'active');
        $client = $project->client;
      }
      $currency = Currencies::random();
      $amount = array_rand_range(1000, 5000)->round(2)
      $gst = 0;
      if ($currency == 'INR') {
        $amount = array_rand_range(50000, 300000)->round(3);
        $gst = $amount * int(config('constants.finance.gst')) / 100;
      }

      $sentOn = $faker->date;

      return [
          'client_id' => $client,
          'project_id' => $project,
          'status' => array_rand(['sent', 'paid']),
          'billing_level' => $billingLevel,
          'currency' => $currency,
          'amount' => $amount,
          'sent_on' => $sentOn,
          'due_on' => $sentOn->addDays(7),
          'receivable_date' => $sentOn->addDays(7),
          'gst' => $gst,
          'file_path' => '',
          'comments' => '',
          'amount_paid' => '',
          'bank_charges' => '',
          'conversion_rate_diff' => '',
          'conversion_rate' => '',
          'tds' => '',
          'tds_percentage' => '',
          'currency_transaction_charge' => '',
          'payment_at' => '',
          'invoice_number' => '',
          'reminder_mail_count' => '',
          'payment_confirmation_mail_sent' => '',
          'term_start_date' => '',
          'term_end_date' => '',
      ];
    }
}
