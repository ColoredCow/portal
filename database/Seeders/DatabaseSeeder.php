<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Database\Seeders\HrDesignationTableSeeder;
use Modules\HR\Database\Seeders\HrDomainTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment(['local', 'staging', 'UAT'])) {
            return 0;
        }

        $this->call(RolesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(HrDomainTableSeeder::class);
        $this->call(HrDesignationTableSeeder::class);
        $this->call(UserDatabaseSeeder::class);
        $this->call(BooksPermissionsSeeder::class);
        $this->call(BookCategoriesTableSeeder::class);

        return true;
    }
}
