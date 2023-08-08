<?php

namespace Modules\Prospect\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProspectDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $prospectPermissions = [
            ['name' => 'prospect.create'],
            ['name' => 'prospect.view'],
            ['name' => 'prospect.update'],
            ['name' => 'prospect.delete'],
        ];
        foreach ($prospectPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($prospectPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
    }
}
