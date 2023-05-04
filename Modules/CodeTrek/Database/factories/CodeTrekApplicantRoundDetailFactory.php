<?php

namespace Modules\CodeTrek\Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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
            //'applicant_id' => CodeTrekApplicant::inRandomOrder()->first()->id,
            'feedback'=>'No',
            //'start_date' => date(),
        ];
    }
}
