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
        Permission::updateOrCreate(['name' => 'hr_universities.create']);
        Permission::updateOrCreate(['name' => 'hr_universities.view']);
        Permission::updateOrCreate(['name' => 'hr_universities.update']);
        Permission::updateOrCreate(['name' => 'hr_universities.delete']);
        Permission::updateOrCreate(['name' => 'hr_universities_reports.view']);

        Permission::updateOrCreate(['name' => 'hr_applicants.view']);
        Permission::updateOrCreate(['name' => 'hr_applicants.create']);
        Permission::updateOrCreate(['name' => 'hr_applicants.update']);
        Permission::updateOrCreate(['name' => 'hr_applicants.delete']);
    }
}
