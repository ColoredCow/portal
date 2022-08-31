<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationRoundReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationRoundReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationRoundReview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hr_application_round_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'review_key' => 'feedback',
            'review_value' =>  $this->faker->text(),
        ];
    }

    private function getRandomId()
    {
        return [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
        ];
    }
}
