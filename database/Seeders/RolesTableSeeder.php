<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        \DB::table('roles')->insert([
            0 => [
                'id' => 1,
                'name' => 'super-admin',
                'label' => 'Super Admin',
                'guard_name' => 'web',
                'description' => 'User having this role can access everything into the system.',
            ],
            1 => [
                'id' => 2,
                'name' => 'admin',
                'label' => 'Admin',
                'guard_name' => 'web',
                'description' => 'This will also have all the permissions except adding new Admin into the system.',
            ],
            2 => [
                'id' => 3,
                'name' => 'employee',
                'label' => 'Employee',
                'guard_name' => 'web',
                'description' => 'Limited actions',
            ],
            3 => [
                'id' => 4,
                'name' => 'hr-manager',
                'label' => 'HR',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            4 => [
                'id' => 5,
                'name' => 'Finance',
                'label' => 'Finance',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            5 => [
                'id' => 6,
                'name' => 'volunteer-manager',
                'label' => 'Volunteer Manager',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            6 => [
                'id' => 7,
                'name' => 'book-manager',
                'label' => 'Library',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            7 => [
                'id' => 8,
                'name' => 'user-management',
                'label' => 'User Management',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            8 => [
                'id' => 9,
                'name' => 'client-manager',
                'label' => 'Client Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients',
            ],
            9 => [
                'id' => 10,
                'name' => 'key-account-manager',
                'label' => 'Key Account Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients having him as a key account manager.',
            ],
            10 => [
                'id' => 11,
                'name' => 'project-manager',
                'label' => 'Project Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the projects having him as a project manager.',
            ],
            11 => [
                'id' => 12,
                'name' => 'accountant',
                'label' => 'Accountant',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to view the finance report',
            ]
        ]);
    }
}
