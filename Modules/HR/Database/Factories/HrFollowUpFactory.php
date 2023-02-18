<?php

namespace Modules\HR\Database\Factories;

use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\HR\Entities\FollowUp;

class HrFollowUpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FollowUp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [

            'hr_application_round_id'=> $this->getRandomId()[array_rand($this->getRandomId())],
            'checklist'=> $faker->text(),
            'assigned_to' => null,
            'conducted_by' => User::create()->first()->id,

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
