<?php

namespace Modules\CodeTrek\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;
use Modules\CodeTrek\Database\factories\CodeTrekApplicantFactory;

class CosetrekApplicantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *-.
     * @return void
     */
    public function run()
    {
        CodeTrekApplicant::factory(2)->has(
            CodeTrekApplicantRoundDetail::factory()->count(1),
            'roundDetails'
        )->create();
    }
}
