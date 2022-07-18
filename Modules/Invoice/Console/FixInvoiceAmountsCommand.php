<?php

namespace Modules\Invoice\Console;

use Illuminate\Console\Command;
use Modules\Invoice\Entities\Invoice;

class FixInvoiceAmountsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'invoice:fix-invoice-amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix invoice amount on local and UAT environment';

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
        if (! in_array(config('app.env'), ['local', 'staging'])) {
            $this->error('This command works in local and staging env only.');

            return false;
        }

        $invoices = Invoice::whereNotNull('amount')->get();

        foreach ($invoices ?? [] as $invoice) {
            if (! is_string($invoice->amount) && $invoice->amount > 0) {
                continue;
            }

            $invoice->amount = rand(100, 10000);

            if ($invoice->gst) {
                $invoice->gst = $invoice->amount * 0.18;
            }

            $invoice->save();
        }
    }
}
