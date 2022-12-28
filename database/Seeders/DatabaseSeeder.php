<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Database\Seeders\HRDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // roles
        $this->call(HRDatabaseSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        if (! app()->environment('production')) {
            $this->call(UsersTableSeeder::class);
        }

        // books
        $this->call(BooksPermissionsSeeder::class);
        $this->call(BookCategoriesTableSeeder::class);
    }
}
