<?php

namespace Modules\Invoice\Console\GoogleChat;

use Illuminate\Console\Command;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Support\Facades\Notification;
use Modules\Invoice\Notifications\GoogleChat\SendPaymentReceivedNotification;

class SendPaymentReceivedNotificationForProjectInvoice extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'invoice:send-payment-received-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a notification of invoice paid in Google Chat .';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $paidInvoices = Invoice::where('status', 'paid')->get();
        foreach ($paidInvoices as $invoice) {
            $project = $invoice->project;
            if ($project->google_chat_webhook_url) {
                Notification::route('googleChat', $project->google_chat_webhook_url)
                    ->notify(new SendPaymentReceivedNotification($invoice));
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
