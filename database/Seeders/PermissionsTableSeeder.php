<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->delete();
        Artisan::call('permission:cache-reset');

        Permission::create(['name' => 'finance_reports.view']);

        Permission::create(['name' => 'finance_invoices.create']);
        Permission::create(['name' => 'finance_invoices.view']);
        Permission::create(['name' => 'finance_invoices.update']);
        Permission::create(['name' => 'finance_invoices.delete']);

        Permission::create(['name' => 'clients.create']);
        Permission::create(['name' => 'clients.view']);
        Permission::create(['name' => 'clients.update']);
        Permission::create(['name' => 'clients.delete']);

        Permission::create(['name' => 'projects.create']);
        Permission::create(['name' => 'projects.view']);
        Permission::create(['name' => 'projects.update']);
        Permission::create(['name' => 'projects.delete']);

        Permission::create(['name' => 'settings.create']);
        Permission::create(['name' => 'settings.view']);
        Permission::create(['name' => 'settings.update']);
        Permission::create(['name' => 'settings.delete']);

        Permission::create(['name' => 'hr_recruitment_applicants.create']);
        Permission::create(['name' => 'hr_recruitment_applicants.view']);
        Permission::create(['name' => 'hr_recruitment_applicants.update']);
        Permission::create(['name' => 'hr_recruitment_applicants.delete']);

        Permission::create(['name' => 'hr_recruitment_applications.create']);
        Permission::create(['name' => 'hr_recruitment_applications.view']);
        Permission::create(['name' => 'hr_recruitment_applications.update']);
        Permission::create(['name' => 'hr_recruitment_applications.delete']);

        Permission::create(['name' => 'hr_recruitment_jobs.create']);
        Permission::create(['name' => 'hr_recruitment_jobs.view']);
        Permission::create(['name' => 'hr_recruitment_jobs.update']);
        Permission::create(['name' => 'hr_recruitment_jobs.delete']);

        Permission::create(['name' => 'hr_recruitment_reports.view']);

        Permission::create(['name' => 'hr_recruitment_campaigns.create']);
        Permission::create(['name' => 'hr_recruitment_campaigns.view']);
        Permission::create(['name' => 'hr_recruitment_campaigns.update']);
        Permission::create(['name' => 'hr_recruitment_campaigns.delete']);

        Permission::create(['name' => 'hr_employees.create']);
        Permission::create(['name' => 'hr_employees.view']);
        Permission::create(['name' => 'hr_employees.update']);
        Permission::create(['name' => 'hr_employees.delete']);

        Permission::create(['name' => 'hr_employees_reports.view']);

        Permission::create(['name' => 'hr_volunteers_applications.create']);
        Permission::create(['name' => 'hr_volunteers_applications.view']);
        Permission::create(['name' => 'hr_volunteers_applications.update']);
        Permission::create(['name' => 'hr_volunteers_applications.delete']);

        Permission::create(['name' => 'hr_volunteers_reports.view']);

        Permission::create(['name' => 'hr_volunteers_campaigns.create']);
        Permission::create(['name' => 'hr_volunteers_campaigns.view']);
        Permission::create(['name' => 'hr_volunteers_campaigns.update']);
        Permission::create(['name' => 'hr_volunteers_campaigns.delete']);

        Permission::create(['name' => 'crm_talent.create']);
        Permission::create(['name' => 'crm_talent.view']);
        Permission::create(['name' => 'crm_talent.update']);
        Permission::create(['name' => 'crm_talent.delete']);

        Permission::create(['name' => 'crm_client.create']);
        Permission::create(['name' => 'crm_client.view']);
        Permission::create(['name' => 'crm_client.update']);
        Permission::create(['name' => 'crm_client.delete']);

        Permission::create(['name' => 'weeklydoses.view']);

        Permission::create(['name' => 'library_books.create']);
        Permission::create(['name' => 'library_books.view']);
        Permission::create(['name' => 'library_books.update']);
        Permission::create(['name' => 'library_books.delete']);

        Permission::create(['name' => 'library_book_category.create']);
        Permission::create(['name' => 'library_book_category.view']);
        Permission::create(['name' => 'library_book_category.update']);
        Permission::create(['name' => 'library_book_category.delete']);

        Permission::create(['name' => 'infrastructure.billings.create']);
        Permission::create(['name' => 'infrastructure.billings.view']);
        Permission::create(['name' => 'infrastructure.billings.update']);
        Permission::create(['name' => 'infrastructure.billings.delete']);

        Permission::create(['name' => 'infrastructure.backups.create']);
        Permission::create(['name' => 'infrastructure.backups.view']);
        Permission::create(['name' => 'infrastructure.backups.update']);
        Permission::create(['name' => 'infrastructure.backups.delete']);

        Permission::create(['name' => 'infrastructure.ec2-instances.create']);
        Permission::create(['name' => 'infrastructure.ec2-instances.view']);
        Permission::create(['name' => 'infrastructure.ec2-instances.update']);
        Permission::create(['name' => 'infrastructure.ec2-instances.delete']);
    }
}
