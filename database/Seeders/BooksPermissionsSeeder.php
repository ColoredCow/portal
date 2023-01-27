<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class BooksPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('permission:cache-reset');

        $weeklyDosesPermissions = [
            ['name' => 'weeklydoses.view']
        ];

        $libraryBooksPermissions = [
            ['name' => 'library_books.create'],
            ['name' => 'library_books.view'],
            ['name' => 'library_books.update'],
            ['name' => 'library_books.delete'],
        ];

        $libraryBookCategoriesPermissions = [
            ['name' => 'library_book_category.create'],
            ['name' => 'library_book_category.view'],
            ['name' => 'library_book_category.update'],
            ['name' => 'library_book_category.delete'],
        ];

        $allKnowledgeCafePermissions = array_merge($weeklyDosesPermissions, $libraryBooksPermissions, $libraryBookCategoriesPermissions);

        foreach ($allKnowledgeCafePermissions as $permission) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach ($allKnowledgeCafePermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for employee role
        $employeeRole = Role::where(['name' => 'employee'])->first();
        foreach ($allKnowledgeCafePermissions as $permission) {
            $employeeRole->givePermissionTo($permission);
        }
    }
}
