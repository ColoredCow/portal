<?php

namespace Modules\Report\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ReportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $financeReportsPermissions = [
            ['name' => 'finance_reports.view'],
        ];

        $reportsPermissions = [
            ['name' => 'report.view'],
            ['name' => 'report.edit'],
        ];
        $allReportsPermissions = array_merge($financeReportsPermissions, $reportsPermissions);

        foreach ($allReportsPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($allReportsPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for finance-manager role
        $financeManagerRole = Role::where(['name' => 'finance-manager'])->first();
        foreach ($financeReportsPermissions as $permission) {
            $financeManagerRole->givePermissionTo($permission);
        }
    }
}
