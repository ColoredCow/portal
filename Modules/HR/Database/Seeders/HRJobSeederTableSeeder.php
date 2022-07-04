<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Job;
use Illuminate\Database\Eloquent\Model;

class HRJobSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Job::factory()
            ->count(2)
            ->create();
    }
}
