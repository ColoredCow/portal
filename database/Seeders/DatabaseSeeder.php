<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!app()->environment('production'))
        {
            $this->call(UsersTableSeeder::class);
        }
            $this->call(RolesTableSeeder::class);
            $this->call(CountriesTableSeeder::class);
            $this->call(BooksPermissionsSeeder::class);
            $this->call(BookCategoriesTableSeeder::class);
        
    }
}
