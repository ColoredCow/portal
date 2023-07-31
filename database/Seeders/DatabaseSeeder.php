<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Database\Seeders\HrDomainTableSeeder;
use Modules\HR\Database\Seeders\HrDesignationTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('production')) {
            return false;
        }

        $this->call(RolesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(HrDomainTableSeeder::class);
        $this->call(HrDesignationTableSeeder::class);

        return true;
    }
}
