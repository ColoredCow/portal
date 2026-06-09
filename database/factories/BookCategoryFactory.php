<?php

namespace Database\Factories;

use App\Models\KnowledgeCafe\Library\BookCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(10),
        ];
    }
}
