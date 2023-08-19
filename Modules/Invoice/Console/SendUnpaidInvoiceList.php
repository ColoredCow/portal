<?php

namespace Modules\Invoice\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Invoice\Contracts\InvoiceServiceContract;
use Modules\Invoice\Emails\SendUnpaidInvoiceListMail;

class SendUnpaidInvoiceList extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'invoice:send-unpaid-invoice-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a list of all the unpaid invoices to the finance team.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = app(InvoiceServiceContract::class);
        $unpaidInvoices = $service->getUnpaidInvoices();
        Mail::send(new SendUnpaidInvoiceListMail($unpaidInvoices));
    }
}
