<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\HrJobDesignation;

class HrDesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('hr.opportunities.designation') as $slug => $designation) {
            HrJobDesignation::updateOrCreate([
                    'slug' => $slug,
                ], [
                    'designation' => $designation,
                ]
            );
        }
    }
}
