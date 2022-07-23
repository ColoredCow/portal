<?php

namespace Modules\SalesAutomation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class SalesAutomationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Permission::updateOrCreate(['name' => 'sales_automation.create']);
        Permission::updateOrCreate(['name' => 'sales_automation.view']);
        Permission::updateOrCreate(['name' => 'sales_automation.update']);
        Permission::updateOrCreate(['name' => 'sales_automation.delete']);

        Permission::updateOrCreate(['name' => 'sales_reports.create']);
        Permission::updateOrCreate(['name' => 'sales_reports.view']);
        Permission::updateOrCreate(['name' => 'sales_reports.update']);
        Permission::updateOrCreate(['name' => 'sales_reports.delete']);
    }
}
