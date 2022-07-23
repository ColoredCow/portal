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
        Model::unguard();
        Permission::updateOrCreate(['name' => 'user_management.create']);
        Permission::updateOrCreate(['name' => 'user_management.view']);
        Permission::updateOrCreate(['name' => 'user_management.update']);
        Permission::updateOrCreate(['name' => 'user_management.delete']);

        Permission::updateOrCreate(['name' => 'user_role_management.create']);
        Permission::updateOrCreate(['name' => 'user_role_management.view']);
        Permission::updateOrCreate(['name' => 'user_role_management.update']);
        Permission::updateOrCreate(['name' => 'user_role_management.delete']);
    }
}
