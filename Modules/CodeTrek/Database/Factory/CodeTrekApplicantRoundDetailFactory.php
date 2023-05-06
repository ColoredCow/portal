<?php

namespace Modules\CodeTrek\Database\Factories;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

class CodetrekApplicantRoundDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = CodeTrekApplicantRoundDetail::class;
    public function definition()
    {
        return [
            'feedback'=>'No',
            'start_date' => Carbon::today(),
        ];
    }
}
