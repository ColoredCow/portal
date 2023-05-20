<?php

namespace Modules\CodeTrek\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

class CodeTrekApplicantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *-.
     * @return void
     */
    public function run()
    {
        if (! app()->environment('production')) {
           CodeTrekApplicant::factory(2)->has(
                CodeTrekApplicantRoundDetail::factory()->count(1),
                'roundDetails'
            )->create();
        }
    }
}
