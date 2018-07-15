<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HrApplicantCreatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');
        $permission = Permission::firstOrCreate(['name' => 'hr_applicants.create']);
        $role = Role::findByName('super-admin');
        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
    }
}
