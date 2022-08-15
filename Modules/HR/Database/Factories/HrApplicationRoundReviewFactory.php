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
            'hr_application_round_id'=> 1,
            'review_key'=> 2,
            'review_value'=> 2,
        ];
    }
}
