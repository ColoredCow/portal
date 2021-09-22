<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

        //if (\DB::table('users')->where('email', 'user@coloredcow.com')->doesntExist())
        if (User::where('email', '=', 'user@coloredcow.com')->doesntExist()) {
            \DB::table('users')->insert([
                0 => [
                    'email' => 'user@coloredcow.com',
                    'name' => 'ColoredCow User',
                    'password' => Hash::make('12345678'),
                    'provider' => 'default',
                    'provider_id' => 'default'
                     ]
                ]);

         }

        if (User::where('email', '=', 'john@example.com')->doesntExist()) {
            \DB::table('users')->insert([
                0 => [
                    'email' => 'john@example.com',
                    'name' => 'John Doe',
                    'password' => Hash::make('12345678'),
                    'provider' => 'default',
                    'provider_id' => 'default'
                     ]
                ]);
        }

        $this->assignRoles();
    }

    private function assignRoles()
    {
        $users = User::all();
        $role = Role::where('name', 'super-admin')->first();

        foreach ($users as $user) {
            $user->assignRole($role);
        }
    }
}
