<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'super-admin',
                'label' => 'Super Admin',
                'guard_name' => 'web',
                'description' => 'User having this role can access everything into the system.',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'label' => 'Admin',
                'guard_name' => 'web',
                'description' => 'This will also have all the permissions except adding new Admin into the system.',
            ],
            [
                'id' => 3,
                'name' => 'employee',
                'label' => 'Employee',
                'guard_name' => 'web',
                'description' => 'Limited actions',
            ],
            [
                'id' => 4,
                'name' => 'hr-manager',
                'label' => 'HR',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'id' => 5,
                'name' => 'Finance',
                'label' => 'Finance',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'id' => 6,
                'name' => 'volunteer-manager',
                'label' => 'Volunteer Manager',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'id' => 7,
                'name' => 'book-manager',
                'label' => 'Library',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'id' => 8,
                'name' => 'user-management',
                'label' => 'User Management',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ],
            [
                'id' => 9,
                'name' => 'client-manager',
                'label' => 'Client Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients',
            ],
            [
                'id' => 10,
                'name' => 'key-account-manager',
                'label' => 'Key Account Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients having him as a key account manager.',
            ],
            [
                'id' => 11,
                'name' => 'project-manager',
                'label' => 'Project Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to perform all operations in the projects module.',
            ],
            [
                'id' => 12,
                'name' => 'accountant',
                'label' => 'Accountant',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to view the finance report',
            ]
        ]);
    }
}
