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
         // roles
         $this->call(RolesTableSeeder::class);
         $this->call(CountriesTableSeeder::class);
         $this->call(UsersTableSeeder::class);
 
         // books
         $this->call(BooksPermissionsSeeder::class);
         $this->call(BookCategoriesTableSeeder::class);
  
    }
}
