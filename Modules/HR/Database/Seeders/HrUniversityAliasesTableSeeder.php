<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\UniversityAlias;

class HrUniversityAliasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            UniversityAlias::factory()
                ->count(5)
                ->create();

            // $this->call("OthersTableSeeder");
        }
    }
}
