<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions');
        Artisan::call('permission:cache-reset');

        Permission::updateOrCreate(['name' => 'finance_reports.view']);

        Permission::updateOrCreate(['name' => 'finance_invoices.create']);
        Permission::updateOrCreate(['name' => 'finance_invoices.view']);
        Permission::updateOrCreate(['name' => 'finance_invoices.update']);
        Permission::updateOrCreate(['name' => 'finance_invoices.delete']);

        Permission::updateOrCreate(['name' => 'clients.create']);
        Permission::updateOrCreate(['name' => 'clients.view']);
        Permission::updateOrCreate(['name' => 'clients.update']);
        Permission::updateOrCreate(['name' => 'clients.delete']);

        Permission::updateOrCreate(['name' => 'projects.create']);
        Permission::updateOrCreate(['name' => 'projects.view']);
        Permission::updateOrCreate(['name' => 'projects.update']);
        Permission::updateOrCreate(['name' => 'projects.delete']);

        Permission::updateOrCreate(['name' => 'settings.create']);
        Permission::updateOrCreate(['name' => 'settings.view']);
        Permission::updateOrCreate(['name' => 'settings.update']);
        Permission::updateOrCreate(['name' => 'settings.delete']);

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

        Permission::updateOrCreate(['name' => 'crm_talent.create']);
        Permission::updateOrCreate(['name' => 'crm_talent.view']);
        Permission::updateOrCreate(['name' => 'crm_talent.update']);
        Permission::updateOrCreate(['name' => 'crm_talent.delete']);

        Permission::updateOrCreate(['name' => 'crm_client.create']);
        Permission::updateOrCreate(['name' => 'crm_client.view']);
        Permission::updateOrCreate(['name' => 'crm_client.update']);
        Permission::updateOrCreate(['name' => 'crm_client.delete']);

        Permission::updateOrCreate(['name' => 'weeklydoses.view']);

        Permission::updateOrCreate(['name' => 'library_books.create']);
        Permission::updateOrCreate(['name' => 'library_books.view']);
        Permission::updateOrCreate(['name' => 'library_books.update']);
        Permission::updateOrCreate(['name' => 'library_books.delete']);

        Permission::updateOrCreate(['name' => 'library_book_category.create']);
        Permission::updateOrCreate(['name' => 'library_book_category.view']);
        Permission::updateOrCreate(['name' => 'library_book_category.update']);
        Permission::updateOrCreate(['name' => 'library_book_category.delete']);

        Permission::updateOrCreate(['name' => 'infrastructure.billings.create']);
        Permission::updateOrCreate(['name' => 'infrastructure.billings.view']);
        Permission::updateOrCreate(['name' => 'infrastructure.billings.update']);
        Permission::updateOrCreate(['name' => 'infrastructure.billings.delete']);

        Permission::updateOrCreate(['name' => 'infrastructure.backups.create']);
        Permission::updateOrCreate(['name' => 'infrastructure.backups.view']);
        Permission::updateOrCreate(['name' => 'infrastructure.backups.update']);
        Permission::updateOrCreate(['name' => 'infrastructure.backups.delete']);

        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.create']);
        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.view']);
        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.update']);
        Permission::updateOrCreate(['name' => 'infrastructure.ec2-instances.delete']);
    }
}
