<?php

namespace Modules\ProjectContract\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ProjectContractPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $projectContractPermissions = [
            ['name' => 'projectcontract.view-form'],
            ['name' => 'projectcontract.edit'],
            ['name' => 'projectcontract.delete'],
            ['name' => 'projectscontract.view'],
            ['name' => 'projectscontract.store'],
            ['name' => 'projectscontract.update'],
        ];
        foreach ($projectContractPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($projectContractPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for finance-manager role
        $financeManagerRole = Role::where(['name' => 'finance-manager'])->first();
        foreach ($projectContractPermissions as $permission) {
            $financeManagerRole->givePermissionTo($permission);
        }

        // set permissions for project-manager role 
        $projectManagerRole = Role::where(['name' => 'project-manager'])->first();
        foreach ($projectContractPermissions as $permission) {
            $projectManagerRole->givePermissionTo($permission);
        }
    }
}
