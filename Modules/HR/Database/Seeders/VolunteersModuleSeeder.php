<?php

namespace Modules\HR\Database\Seeders;

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
        Permission::updateOrCreate(['name' => 'hr_volunteers_jobs.create']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_jobs.view']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_jobs.update']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_jobs.delete']);

        $volunteerManager = Role::where(['name' => 'volunteer-manager'])->first();
        $volunteerManager->syncPermissions(Permission::where('name', 'LIKE', 'hr_volunteers%')->get());
    }
}
