<?php
namespace Database\Factories;

use App\Models\KnowledgeCafe\Library\Book;
use App\Models\KnowledgeCafe\Library\BookCategory;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(12),
        'author' => $faker->name,
        'isbn' => $faker->ean13,
        'thumbnail' => $faker->imageUrl(),
        'readable_link' => $faker->url,
        'number_of_copies' => $faker->numberBetween(1, 10),
    ];
});

$factory->define(BookCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(10),
    ];
});
