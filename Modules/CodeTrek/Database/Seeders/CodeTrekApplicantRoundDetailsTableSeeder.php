<?php

namespace Modules\CodeTrek\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

class CodeTrekApplicantRoundDetailsTableSeeder extends Seeder
{
    public function run()
    {
        CodeTrekApplicantRoundDetail::factory()->count(50)->create();
    }
}
