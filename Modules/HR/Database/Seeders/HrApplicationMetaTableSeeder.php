<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\ApplicationMeta;

class HrApplicationMetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            ApplicationMeta::factory()
                ->count(20)
                ->create();
        }
    }
}
