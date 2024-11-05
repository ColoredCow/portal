<?php

namespace Modules\Invoice\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Invoice\Database\Factories\InvoiceFactory;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = rand(5, 10);

        for ($i = 0; $i < $count; $i++) {
            InvoiceFactory::new([
                'status' => 'sent',
            ])->create();
        }
    }
}
