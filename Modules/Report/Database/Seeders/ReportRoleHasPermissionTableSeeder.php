<?php

namespace Modules\Report\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ReportRoleHasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $roles = ['super-admin', 'admin', 'Finance', 'Accountant'];
        foreach ($roles as $key) {
            $role = Role::where(['name' => $key])->first();
            $role->syncPermissions(Permission::whereIn('name', [
                'report.view',
                'report.edit',
            ])->get());
        }

        $accountant = Role::where(['name' => 'accountant'])->first();
        $accountant->givePermissionTo('finance_reports.view');
    }
}
