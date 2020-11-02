<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'super-admin',
                'label' => 'Super Admin',
                'guard_name' => 'web',
                'description' => 'User having this role can access everything into the system.',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'admin',
                'label' => 'Admin',
                'guard_name' => 'web',
                'description' => 'This will also have all the permissions except adding new Admin into the system.',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'employee',
                'label' => 'Employee',
                'guard_name' => 'web',
                'description' => 'Limited actions',
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'hr-manager',
                'label' => 'HR',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Finance',
                'label' => 'Finance',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'volunteer-manager',
                'label' => 'Volunteer Manager',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'book-manager',
                'label' => 'Library',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'user-management',
                'label' => 'User Management',
                'guard_name' => 'web',
                'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old',
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'client-manager',
                'label' => 'Client Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients',
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'key-account-manager',
                'label' => 'Key Account Manager',
                'guard_name' => 'web',
                'description' => 'User having this role will be able to Create, Update and Delete the clients having him as a key account manager.',
            ),
        ));
    }
}
