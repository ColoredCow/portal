<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class VolunteersModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'volunteer-manager']);

        $volunteerManager = Role::where(['name' => 'volunteer-manager'])->first();
        $volunteerManager->syncPermissions(Permission::where('name', 'LIKE', 'hr_volunteers%')->get());
    }
}
