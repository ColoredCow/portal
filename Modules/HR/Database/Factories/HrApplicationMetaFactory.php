<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\ApplicationMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationMetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationMeta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hr_application_id' => $this->getapplicationId()[array_rand($this->getapplicationId())],
            'value' => $this->faker->text(),
            'key' => 'form-data'
        ];
    }

    private function getapplicationId()
    {
        return [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '9',
            '10',
        ];
    }
}
