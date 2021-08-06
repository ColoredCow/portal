<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalaryConfigurationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('salary_configurations')->delete();
    }
}
