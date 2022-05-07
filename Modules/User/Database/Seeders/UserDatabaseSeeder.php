<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;

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

        if (! app()->environment('production')) {
            $role = Role::where('name', 'super-admin')->first();
            $users = User::factory()
                ->count(3)
                ->create();

            foreach ($users as $user) {
                $user->assignRole($role);
            }
        }
    }
}
