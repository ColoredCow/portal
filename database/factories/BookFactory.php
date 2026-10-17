<?php

namespace Database\Factories;

use App\Models\KnowledgeCafe\Library\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(12),
            'author' => $this->faker->name,
            'isbn' => $this->faker->ean13,
            'thumbnail' => $this->faker->imageUrl(),
            'readable_link' => $this->faker->url,
            'number_of_copies' => $this->faker->numberBetween(1, 10),
        ];
    }
}
