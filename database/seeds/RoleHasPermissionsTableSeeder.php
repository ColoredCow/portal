<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::where(['name' => 'super-admin'])->first();
        $superAdmin->syncPermissions(Permission::all());

        $employee = Role::where(['name' => 'employee'])->first();
        $employee->syncPermissions(Permission::whereIn('name', [
            'hr_employees.view',
            'library_books.view',
            'weeklydoses.view',
        ])->get());

        $accountant = Role::where(['name' => 'accountant'])->first();
        $accountant->givePermissionTo('finance_reports.view');

        $hrManager=Role::where(['name'=>'hr-manager'])->first();
        $hrManager->syncPermissions(Permission::whereIn('name', [
            'hr_universities.view',
            'hr_universities.create',
            'hr_universities.update',
            'hr_universities.delete',
            'hr_volunteers_campaigns.create',
            'hr_volunteers_campaigns.view',
            'hr_volunteers_campaigns.update',
            'hr_volunteers_campaigns.delete',
            'hr_volunteers_reports.view',
            'hr_volunteers_applications.create',
            'hr_volunteers_applications.view',
            'hr_volunteers_applications.update',
            'hr_volunteers_applications.delete',
            'hr_employees_reports.view',
            'hr_employees.delete',
            'hr_employees.create',
            'hr_employees.update',
            'hr_employees.view',
            'hr_recruitment_campaigns.delete',
            'hr_recruitment_campaigns.create',
            'hr_recruitment_campaigns.view',
            'hr_recruitment_campaigns.update',
            'hr_recruitment_reports.view',
            'hr_recruitment_jobs.create',
            'hr_recruitment_jobs.delete',
            'hr_recruitment_jobs.update',
            'hr_recruitment_jobs.view',
            'hr_recruitment_applications.create',
            'hr_recruitment_applications.delete',
            'hr_recruitment_applications.update',
            'hr_recruitment_applications.view',
            'hr_recruitment_applicants.create',
            'hr_recruitment_applicants.delete',
            'hr_recruitment_applicants.update',
            'hr_recruitment_applicants.view'
        ])->get());
    }
}
