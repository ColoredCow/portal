<?php

namespace Modules\CodeTrek\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class CodeTrekApplicantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CodeTrekApplicant::factory()->count(50)->create();
    }
}
