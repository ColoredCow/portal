<?php

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Media\Entities\Media;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
            Media::factory()
            ->count(2)
            ->create();
        }
    }
}
