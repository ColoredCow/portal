<?php

namespace App\Console\Commands;

use Modules\Invoice\Entities\Invoice;
use App\Models\InvoicePaymentsDetails;
use Illuminate\Console\Command;

class MovePaidData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:paid-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Paid Data from invoice to invoice payment details';

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
     * @return int
     */
    public function handle()
    {
        $paidData = Invoice::where('status', 'paid')->get(['id', 'status', 'gst', 'comments', 'bank_charges', 'conversion_rate_diff', 'conversion_rate', 'tds', 'tds_percentage', 'payment_at']);

        $mappedData = $paidData->map(function ($item) {
            return [
                'invoice_id' => $item['id'],
                'status' => $item['status'],
                'gst' => $item['gst'],
                'comments' => $item['comments'],
                'bank_charges' => $item['bank_charges'],
                'conversion_rate_diff' => $item['conversion_rate_diff'],
                'conversion_rate' => $item['conversion_rate'],
                'tds' => $item['tds'],
                'tds_percentage' => $item['tds_percentage'],
                'last_amount_paid_on' => $item['payment_at']
            ];
        });

        InvoicePaymentsDetails::insert($mappedData->toArray());
        
        return 0;
    }
}
