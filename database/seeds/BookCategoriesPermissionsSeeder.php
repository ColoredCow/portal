<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BookCategoriesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'library_book_category.create']);
        Permission::create(['name' => 'library_book_category.view']);
        Permission::create(['name' => 'library_book_category.update']);
        Permission::create(['name' => 'library_book_category.delete']);

        $superAdmin = Role::where(['name' => 'super-admin'])->first();
        $superAdmin->syncPermissions(Permission::where('name', 'LIKE', "%library_book_category%")->get());
    }
}
