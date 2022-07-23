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

        Permission::updateOrCreate(['name' => 'hr_recruitment_applicants.create']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_applicants.view']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_applicants.update']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_applicants.delete']);

        Permission::updateOrCreate(['name' => 'hr_recruitment_applications.create']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_applications.view']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_applications.update']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_applications.delete']);

        Permission::updateOrCreate(['name' => 'hr_recruitment_jobs.create']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_jobs.view']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_jobs.update']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_jobs.delete']);

        Permission::updateOrCreate(['name' => 'hr_recruitment_reports.view']);

        Permission::updateOrCreate(['name' => 'hr_recruitment_campaigns.create']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_campaigns.view']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_campaigns.update']);
        Permission::updateOrCreate(['name' => 'hr_recruitment_campaigns.delete']);

        Permission::updateOrCreate(['name' => 'hr_employees.create']);
        Permission::updateOrCreate(['name' => 'hr_employees.view']);
        Permission::updateOrCreate(['name' => 'hr_employees.update']);
        Permission::updateOrCreate(['name' => 'hr_employees.delete']);

        Permission::updateOrCreate(['name' => 'hr_employees_reports.view']);

        Permission::updateOrCreate(['name' => 'hr_volunteers_applications.create']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_applications.view']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_applications.update']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_applications.delete']);

        Permission::updateOrCreate(['name' => 'hr_volunteers_reports.view']);

        Permission::updateOrCreate(['name' => 'hr_volunteers_campaigns.create']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_campaigns.view']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_campaigns.update']);
        Permission::updateOrCreate(['name' => 'hr_volunteers_campaigns.delete']);

        Permission::updateOrCreate(['name' => 'hr_settings.create']);
        Permission::updateOrCreate(['name' => 'hr_settings.view']);
        Permission::updateOrCreate(['name' => 'hr_settings.update']);
        Permission::updateOrCreate(['name' => 'hr_settings.delete']);
    }
}
