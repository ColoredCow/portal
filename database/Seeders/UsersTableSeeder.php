<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultSuperAdmin();
        $this->createSuperAdmin();
        $this->createAdmin();
        $this->createEmployee();
        $this->createUserWithoutRole();
    }

    private function createDefaultSuperAdmin()
    {
        $user = User::create([
            'email' => 'user@coloredcow.com',
            'name' => 'ColoredCow User',
            'password' => Hash::make('12345678'),
            'provider' => 'default',
            'provider_id' => 'default',
        ]);
        $role = Role::where('name', 'super-admin')->first();
        $user->assignRole($role);
    }

    private function createSuperAdmin()
    {
        $user = User::create([
            'email' => 'superadmin@coloredcow.com',
            'name' => 'Super Admin',
            'password' => Hash::make('12345678'),
            'provider' => 'default',
            'provider_id' => 'default',
        ]);
        $role = Role::where('name', 'super-admin')->first();
        $user->assignRole($role);
    }

    private function createAdmin()
    {
        $user = User::create([
            'email' => 'admin@coloredcow.com',
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
            'provider' => 'default',
            'provider_id' => 'default',
        ]);
        $role = Role::where('name', 'admin')->first();
        $user->assignRole($role);
    }

    private function createEmployee()
    {
        $user = User::create([
            'email' => 'employee@coloredcow.com',
            'name' => 'Employee User',
            'password' => Hash::make('12345678'),
            'provider' => 'default',
            'provider_id' => 'default',
        ]);
        $role = Role::where('name', 'employee')->first();
        $user->assignRole($role);
    }

    private function createUserWithoutRole()
    {
        $user = User::create([
            'email' => 'default@coloredcow.com',
            'name' => 'Default User',
            'password' => Hash::make('12345678'),
            'provider' => 'default',
            'provider_id' => 'default',
        ]);
    }
}
