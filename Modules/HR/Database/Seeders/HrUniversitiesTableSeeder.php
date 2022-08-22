<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\University;

class HrUniversitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            University::factory()
                ->count(10)
                ->create();

            // $this->call("OthersTableSeeder");
        }
    }
}
