<?php

namespace Modules\Invoice\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Database\Eloquent\Model;

class ResetInvoiceNumberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach (Invoice::all() as $invoice) {
            $invoice->invoice_number = pathinfo($invoice->file_path, PATHINFO_FILENAME);
            $invoice->save();
        }
    }
}
