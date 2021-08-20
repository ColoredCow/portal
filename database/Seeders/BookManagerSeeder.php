<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BookManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookManager = Role::create(['name' => 'book-manager']);
        $bookManager->syncPermissions(Permission::where('name', 'LIKE', 'library%')->get());
    }
}
