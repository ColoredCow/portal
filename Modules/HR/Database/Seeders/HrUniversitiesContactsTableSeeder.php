<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\UniversityContact;

class HrUniversitiesContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            UniversityContact::factory()
                ->count(4)
                ->create();

            // $this->call("OthersTableSeeder");
        }
        // $this->call("OthersTableSeeder");
    }
}
