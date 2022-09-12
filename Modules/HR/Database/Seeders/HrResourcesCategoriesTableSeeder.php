<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class HrResourcesCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            Category::factory()
                ->count(4)
                ->create();
        }
    }
}
