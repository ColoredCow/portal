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
        Permission::create(['name' => 'read.finance_reports']);

        Permission::create(['name' => 'create.finance_invoices']);
        Permission::create(['name' => 'read.finance_invoices']);
        Permission::create(['name' => 'update.finance_invoices']);
        Permission::create(['name' => 'delete.finance_invoices']);

        Permission::create(['name' => 'create.clients']);
        Permission::create(['name' => 'read.clients']);
        Permission::create(['name' => 'update.clients']);
        Permission::create(['name' => 'delete.clients']);

        Permission::create(['name' => 'create.projects']);
        Permission::create(['name' => 'read.projects']);
        Permission::create(['name' => 'update.projects']);
        Permission::create(['name' => 'delete.projects']);

        Permission::create(['name' => 'create.hr_applicants']);
        Permission::create(['name' => 'read.hr_applicants']);
        Permission::create(['name' => 'update.hr_applicants']);
        Permission::create(['name' => 'delete.hr_applicants']);

        Permission::create(['name' => 'read.weeklydoses']);

        Permission::create(['name' => 'create.library_books']);
        Permission::create(['name' => 'read.library_books']);
        Permission::create(['name' => 'update.library_books']);
        Permission::create(['name' => 'delete.library_books']);
    }
}
