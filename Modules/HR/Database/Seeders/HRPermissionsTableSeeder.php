<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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

        $hrUniversitiesPermissions = [
            ['name' => 'hr_universities.create'],
            ['name' => 'hr_universities.view'],
            ['name' => 'hr_universities.update'],
            ['name' => 'hr_universities.delete'],
            ['name' => 'hr_universities_reports.view'],
        ];

        $hrApplicantsPermissions = [
            ['name' => 'hr_applicants.create'],
            ['name' => 'hr_applicants.view'],
            ['name' => 'hr_applicants.update'],
            ['name' => 'hr_applicants.delete'],
        ];

        $hrRecruitmentApplicantsPermissions = [
            ['name' => 'hr_recruitment_applicants.create'],
            ['name' => 'hr_recruitment_applicants.view'],
            ['name' => 'hr_recruitment_applicants.update'],
            ['name' => 'hr_recruitment_applicants.delete'],
        ];

        $hrRecruitmentApplicationsPermissions = [
            ['name' => 'hr_recruitment_applications.create'],
            ['name' => 'hr_recruitment_applications.view'],
            ['name' => 'hr_recruitment_applications.update'],
            ['name' => 'hr_recruitment_applications.delete'],
        ];

        $hrRecruitmentJobsPermissions = [
            ['name' => 'hr_recruitment_jobs.create'],
            ['name' => 'hr_recruitment_jobs.view'],
            ['name' => 'hr_recruitment_jobs.update'],
            ['name' => 'hr_recruitment_jobs.delete'],
        ];

        $hrRecruitmentReportsPermissions = [
            ['name' => 'hr_recruitment_reports.view'],
        ];

        $hrRecruitmentCampaignsPermissions = [
            ['name' => 'hr_recruitment_campaigns.create'],
            ['name' => 'hr_recruitment_campaigns.view'],
            ['name' => 'hr_recruitment_campaigns.update'],
            ['name' => 'hr_recruitment_campaigns.delete'],
        ];

        $hrEmployeesPermissions = [
            ['name' => 'hr_employees.create'],
            ['name' => 'hr_employees.view'],
            ['name' => 'hr_employees.update'],
            ['name' => 'hr_employees.delete'],
        ];

        $hrEmployeesReportsPermissions = [
            ['name' => 'hr_employees_reports.view'],
        ];

        $hrVolunteersApplicationsPermissions = [
            ['name' => 'hr_volunteers_applications.create'],
            ['name' => 'hr_volunteers_applications.view'],
            ['name' => 'hr_volunteers_applications.update'],
            ['name' => 'hr_volunteers_applications.delete'],
        ];

        $hrVolunteersJobsPermissions = [
            ['name' => 'hr_volunteers_jobs.create'],
            ['name' => 'hr_volunteers_jobs.view'],
            ['name' => 'hr_volunteers_jobs.update'],
            ['name' => 'hr_volunteers_jobs.delete'],
        ];

        $hrVolunteersReportsPermissions = [
            ['name' => 'hr_volunteers_reports.view'],
        ];

        $hrVolunteersCampaignsPermissions = [
            ['name' => 'hr_volunteers_campaigns.create'],
            ['name' => 'hr_volunteers_campaigns.view'],
            ['name' => 'hr_volunteers_campaigns.update'],
            ['name' => 'hr_volunteers_campaigns.delete'],
        ];

        $hrSettingsPermissions = [
            ['name' => 'hr_settings.create'],
            ['name' => 'hr_settings.view'],
            ['name' => 'hr_settings.update'],
            ['name' => 'hr_settings.delete'],
        ];
        $hrDesignationPermissions = [
            ['name' => 'hr_designations.create'],
            ['name' => 'hr_designations.view'],
            ['name' => 'hr_designations.update'],
            ['name' => 'hr_designations.delete'],
        ];
        $hrRequistionPermissions = [
            ['name' => 'hr_Requistions.create'],
            ['name' => 'hr_Requistions.view'],
            ['name' => 'hr_Requistions.update'],
            ['name' => 'hr_Requistions.delete'],
        ];
        $allHrPermissions = array_merge(
            $hrUniversitiesPermissions,
            $hrApplicantsPermissions,
            $hrRecruitmentApplicantsPermissions,
            $hrRecruitmentApplicationsPermissions,
            $hrRecruitmentJobsPermissions,
            $hrRecruitmentReportsPermissions,
            $hrRecruitmentCampaignsPermissions,
            $hrEmployeesPermissions,
            $hrEmployeesReportsPermissions,
            $hrVolunteersApplicationsPermissions,
            $hrVolunteersJobsPermissions,
            $hrVolunteersReportsPermissions,
            $hrVolunteersCampaignsPermissions,
            $hrSettingsPermissions,
            $hrDesignationPermissions,
            $hrRequistionPermissions,
        );
        foreach ($allHrPermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($allHrPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for hr-manager role
        $hrManagerRole = Role::where(['name' => 'hr-manager'])->first();
        foreach ($allHrPermissions as $permission) {
            $hrManagerRole->givePermissionTo($permission);
        }
    }
}
