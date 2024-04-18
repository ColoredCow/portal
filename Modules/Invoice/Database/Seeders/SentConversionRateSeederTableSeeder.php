<?php

namespace Modules\Invoice\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Support\Facades\Log;

class SentConversionRateSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $csvFilePath = storage_path('Revennue-Data-Cleanup.csv');
        $csv = array_map('str_getcsv', file($csvFilePath));

        foreach ($csv as $row) {
            $id = $row[0];
            $data = (float) $row[2];

            $existingRow = Invoice::where('invoice_number', $id)->first();

            if ($existingRow) {
                $existingRow->sent_conversion_rate = $data;
                $existingRow->save();
            }
        }

    }
}
