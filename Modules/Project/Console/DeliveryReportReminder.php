<?php

namespace Modules\Project\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Project\Emails\DeliveryReportReminderMail;
use Modules\Project\Services\ProjectService;

class DeliveryReportReminder extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'project:send-pending-delivery-report-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders about pending delivery reports to key account managers.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $service = app(ProjectService::class);
        $keyAccountManagers = $service->getPendingDeliveryReportInvoices();
        foreach ($keyAccountManagers as $keyAccountManager) {
            Mail::send(new DeliveryReportReminderMail($keyAccountManager));
        }
    }
}
