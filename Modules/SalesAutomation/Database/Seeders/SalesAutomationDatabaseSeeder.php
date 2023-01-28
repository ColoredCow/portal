<?php

namespace Modules\SalesAutomation\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
        $salesAutomationPermissions = [
            ['name' => 'sales_automation.create'],
            ['name' => 'sales_automation.view'],
            ['name' => 'sales_automation.update'],
            ['name' => 'sales_automation.delete'],
        ];

        $salesReportsPermissions = [
            ['name' => 'sales_reports.create'],
            ['name' => 'sales_reports.view'],
            ['name' => 'sales_reports.update'],
            ['name' => 'sales_reports.delete'],
        ];

        $allSalesPermissions = array_merge($salesAutomationPermissions, $salesReportsPermissions);
        foreach ($allSalesPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($allSalesPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
    }
}
