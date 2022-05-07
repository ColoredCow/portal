<?php

namespace Modules\Invoice\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

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

        Permission::updateOrCreate(['name' => 'finance_invoices.create']);
        Permission::updateOrCreate(['name' => 'finance_invoices.view']);
        Permission::updateOrCreate(['name' => 'finance_invoices.update']);
        Permission::updateOrCreate(['name' => 'finance_invoices.delete']);
    }
}
