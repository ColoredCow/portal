<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Employee;
use Modules\User\Entities\User;

class ExistingEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (! $user->isActiveEmployee) {
                continue;
            }
            Employee::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'staff_type' => 'Employee',
            ]);
        }
    }
}
