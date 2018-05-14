<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::where(['name' => 'super-admin'])->first();
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::where(['name' => 'admin'])->first();
        $admin->syncPermissions(Permission::all());

        $accountant = Role::where(['name' => 'accountant'])->first();
        $accountant->givePermissionTo('finance_reports.view');
    }
}
