<?php

namespace Modules\CodeTrek\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();

        CodeTrekApplicant::factory()->count(50)->create();
    }
}
