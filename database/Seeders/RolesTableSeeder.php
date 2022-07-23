<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $defaultRoles = [
            [
                'name' => 'super-admin',
                'label' => 'Super Admin',
                'guard_name' => 'web',
                'description' => 'User having this role can access everything into the system.',
            ],
            [
                'name' => 'admin',
                'label' => 'Admin',
                'guard_name' => 'web',
                'description' => 'This will also have all the permissions except adding new Admin into the system.',
            ],
            [
                'name' => 'employee',
                'label' => 'Employee',
                'guard_name' => 'web',
                'description' => 'Limited actions',
            ],
            [
                'name' => 'hr-manager',
                'label' => 'HR',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'name' => 'Finance',
                'label' => 'Finance',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'name' => 'volunteer-manager',
                'label' => 'Volunteer Manager',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'name' => 'book-manager',
                'label' => 'Library',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'name' => 'user-management',
                'label' => 'User Management',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'name' => 'client-manager',
                'label' => 'Client Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients',
            ],
            [
                'name' => 'key-account-manager',
                'label' => 'Key Account Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients having him as a key account manager.',
            ],
            [
                'name' => 'project-manager',
                'label' => 'Project Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to perform all operations in the projects module.',
            ],
            [
                'name' => 'accountant',
                'label' => 'Accountant',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to view the finance report',
            ]
        ];

        foreach ($defaultRoles as $role) {
            Role::updateOrCreate([
                'name' => $role['name'],
            ], $role);
        }
    }
}
