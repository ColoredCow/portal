<?php

namespace Database\Seeders;

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

        $employee = Role::where(['name' => 'employee'])->first();
        $employee->syncPermissions(Permission::whereIn('name', [
            'hr_employees.view',
            'library_books.view',
            'weeklydoses.view',
            'clients.view',
            'projects.view'
        ])->get());
    }
}
