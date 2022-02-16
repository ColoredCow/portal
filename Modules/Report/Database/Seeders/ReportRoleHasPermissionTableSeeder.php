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
            $Role = Role::where(['name' => $key])->first();
            $Role->syncPermission(Permission::whereIn('name', [
                'report.view',
                'report.edit',
            ])->get());
        }
    }
}
