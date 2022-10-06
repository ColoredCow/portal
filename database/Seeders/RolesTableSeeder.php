<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
                'description' => 'All available actions for a basic employer of the company.',
            ],
            [
                'name' => 'hr-manager',
                'label' => 'HR Manager',
                'guard_name' => 'web',
                'description' => 'Someone who is responsible for HR',
            ],
            [
                'name' => 'finance-manager',
                'label' => 'Finance Manager',
                'guard_name' => 'web',
                'description' => 'Someone who is in charge of the finance of the company',
            ],
            [
               'name' => 'intern',
               'label'=> 'Intern',
               'guard_name' => 'web',
               'description' => 'Someone who is in training',
            ],
            [
                'name' => 'contractor',
               'label'=> 'Contractor',
               'guard_name' => 'web',
               'description' => 'Person responsible for handling Contracts',
            ],
            [
                'name' => 'support-staff',
               'label'=> 'Support Staff',
               'guard_name' => 'web',
               'description' => 'Staff supporting the main team',
            ]
        ];

        foreach ($defaultRoles as $role) {
            Role::updateOrCreate([
                'name' => $role['name'],
            ], $role);
        }
    }
}
