<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class HRPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Permission::create(['name' => 'hr_universities.create']);
        Permission::create(['name' => 'hr_universities.view']);
        Permission::create(['name' => 'hr_universities.update']);
        Permission::create(['name' => 'hr_universities.delete']);
        Permission::create(['name' => 'hr_universities_reports.view']);

        Permission::create(['name' => 'hr_applicants.view']);
        Permission::create(['name' => 'hr_applicants.create']);
        Permission::create(['name' => 'hr_applicants.update']);
        Permission::create(['name' => 'hr_applicants.delete']);
    }
}
