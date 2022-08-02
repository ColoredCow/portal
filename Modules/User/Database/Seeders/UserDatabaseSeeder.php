<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UserPermissionsTableSeeder::class);

        if (! app()->environment('production')) {
            $roles = Role::all();
            foreach ($roles as $role) {
                $users = User::factory()
                    ->count(2)
                    ->create();

                foreach ($users as $user) {
                    $user->assignRole($role);
                }
            }
        }
    }
}
