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
        \DB::table('users')->insert([
            0 => [
                'email' => 'user@coloredcow.com',
                'name' => 'ColoredCow User',
                'password' => Hash::make('12345678'),
                'provider' => 'default',
                'provider_id' => 'default',
            ],
        ]);

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
