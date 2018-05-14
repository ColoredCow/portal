<?php

use Illuminate\Database\Seeder;
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

        Permission::create(['name' => 'hr_applicants.create']);
        Permission::create(['name' => 'hr_applicants.view']);
        Permission::create(['name' => 'hr_applicants.update']);
        Permission::create(['name' => 'hr_applicants.delete']);

        Permission::create(['name' => 'hr_jobs.create']);
        Permission::create(['name' => 'hr_jobs.view']);
        Permission::create(['name' => 'hr_jobs.update']);
        Permission::create(['name' => 'hr_jobs.delete']);

        Permission::create(['name' => 'settings.create']);
        Permission::create(['name' => 'settings.view']);
        Permission::create(['name' => 'settings.update']);
        Permission::create(['name' => 'settings.delete']);

        Permission::create(['name' => 'weeklydoses.view']);

        Permission::create(['name' => 'library_books.create']);
        Permission::create(['name' => 'library_books.view']);
        Permission::create(['name' => 'library_books.update']);
        Permission::create(['name' => 'library_books.delete']);
    }
}
