<?php

namespace Modules\HR\Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

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
