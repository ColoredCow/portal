<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'organization-admin']);
        Role::create(['name' => 'employee']);
        Role::create(['name' => 'hr-manager']);
        Role::create(['name' => 'accountant']);
    }
}
