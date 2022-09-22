<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class UserPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::guarded();
        Permission::updateOrCreate(['name' => 'user_management.create']);
        Permission::updateOrCreate(['name' => 'user_management.view']);
        Permission::updateOrCreate(['name' => 'user_management.update']);
        Permission::updateOrCreate(['name' => 'user_management.delete']);

        Permission::updateOrCreate(['name' => 'user_role_management.create']);
        Permission::updateOrCreate(['name' => 'user_role_management.view']);
        Permission::updateOrCreate(['name' => 'user_role_management.update']);
        Permission::updateOrCreate(['name' => 'user_role_management.delete']);

        $userManagementPermissions = [
            ['name' => 'user_management.create'],
            ['name' => 'user_management.view'],
            ['name' => 'user_management.update'],
            ['name' => 'user_management.delete'],
        ];

        $userRoleManagementPermissions = [
            ['name' => 'user_role_management.create'],
            ['name' => 'user_role_management.view'],
            ['name' => 'user_role_management.update'],
            ['name' => 'user_role_management.delete'],
        ];

        $allUsersPermissions = array_merge($userManagementPermissions, $userRoleManagementPermissions);

        foreach ($allUsersPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
