<?php

namespace Modules\Invoice\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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

        $financeInvoicesPermissions = [
            ['name' => 'finance_invoices.create'],
            ['name' => 'finance_invoices.view'],
            ['name' => 'finance_invoices.update'],
            ['name' => 'finance_invoices.delete'],
        ];

        $financeInvoicesSettingsPermissions = [
            ['name' => 'finance_invoices_settings.create'],
            ['name' => 'finance_invoices_settings.view'],
            ['name' => 'finance_invoices_settings.update'],
            ['name' => 'finance_invoices_settings.delete'],
        ];

        $allfinanceInvoicePermissions = array_merge(
            $financeInvoicesPermissions,
            $financeInvoicesSettingsPermissions
        );

        foreach ($allfinanceInvoicePermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($allfinanceInvoicePermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for finance-manager role
        $financeManagerRole = Role::where(['name' => 'finance-manager'])->first();
        foreach ($allfinanceInvoicePermissions as $permission) {
            $financeManagerRole->givePermissionTo($permission);
        }
    }
}
