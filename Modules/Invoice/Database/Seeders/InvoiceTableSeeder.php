<?php

namespace Modules\Invoice\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InvoiceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $count = array_rand_int(5, 10);
        for ($i=0; $i < $count; $i++) {
          // create invoice
          InvoiceFactory::make([
            'status' => 'sent'
          ]);
        }
    }
}
