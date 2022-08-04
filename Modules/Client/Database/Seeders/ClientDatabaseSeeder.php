<?php

namespace Modules\Client\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Modules\Client\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ClientDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $clientsPermissions = [
            ['name' => 'clients.create'],
            ['name' => 'clients.view'],
            ['name' => 'clients.update'],
            ['name' => 'clients.delete'],
        ];
        foreach ($clientsPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($clientsPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for employee role
        $employeeRole = Role::where(['name' => 'employee'])->first();
        foreach ($clientsPermissions as $permission) {
            $employeeRole->givePermissionTo($permission);
        }

        // seed fake data
        if (! app()->environment('production')) {
            Client::factory()->count(10)->create();
        }
    }
}
