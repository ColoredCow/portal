<?php

namespace Modules\Invoice\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Invoice\Services\InvoiceService;
use Modules\Invoice\Emails\SendInvoiceReminderMail;

class SendUpcomingInvoiceReminder extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'invoice:send-upcoming-invoice-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a list of all the upcoming invoices to the finance team.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = app(InvoiceService::class);
        $upcomingInvoices = $service->getScheduledInvoicesForMail();
        Mail::send(new SendInvoiceReminderMail($upcomingInvoices));
    }
}
