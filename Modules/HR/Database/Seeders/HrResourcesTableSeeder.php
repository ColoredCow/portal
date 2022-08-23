<?php

namespace Modules\HR\Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class HrResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            Resource::factory()
                ->count(2)
                ->create();
        }
    }
}
