<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BooksPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
        foreach (
            array_merge($weeklyDosesPermissions, $libraryBooksPermissions, $libraryBookCategoriesPermissions)
            as $permission
        ) {
            Permission::updateOrCreate($permission);
        }

        // set permissions for admin role
        $adminRole = Role::where(['name' => 'admin'])->first();
        foreach (
            array_merge($weeklyDosesPermissions, $libraryBooksPermissions, $libraryBookCategoriesPermissions)
            as $permission
        ) {
            $adminRole->givePermissionTo($permission);
        }

        // set permissions for employee role
        $employeeRole = Role::where(['name' => 'employee'])->first();
        foreach (
            array_merge($libraryBooksPermissions, $libraryBookCategoriesPermissions)
            as $permission
        ) {
            $employeeRole->givePermissionTo($permission);
        }
    }
}
