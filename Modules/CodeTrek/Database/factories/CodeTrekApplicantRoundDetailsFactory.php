<?php

namespace Modules\CodeTrek\Database\factories;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

class CodeTrekApplicantRoundDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CodeTrekApplicantRoundDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'applicant_id' => function () {
                return CodeTrekApplicant::factory()->create()->id;
            },
            'latest_round_name' => config('codetrek.rounds.introductory-call.slug'),
            'feedback' => $this->faker->sentence
            ];
    }
}
