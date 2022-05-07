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

        Permission::updateOrCreate(['name' => 'settings.create']);
        Permission::updateOrCreate(['name' => 'settings.view']);
        Permission::updateOrCreate(['name' => 'settings.update']);
        Permission::updateOrCreate(['name' => 'settings.delete']);

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
    }
}
