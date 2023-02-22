<?php

namespace Modules\CodeTrek\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class CodeTrekPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $applicantPermissions = [
            ['name' => 'codetrek_applicant.create'],
            ['name' => 'codetrek_applicant.view'],
            ['name' => 'codetrek_applicant.update'],
            ['name' => 'codetrek_applicant.delete'],
        ];

        foreach ($applicantPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($applicantPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // Give permissions to super-admin role
        $superAdminRole = Role::where(['name' => 'super-admin'])->first();
        foreach ($applicantPermissions as $permission) {
            $superAdminRole->givePermissionTo($permission['name']);
        }
    }
}
