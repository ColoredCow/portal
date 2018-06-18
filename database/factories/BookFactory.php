<?php

use Faker\Generator as Faker;
use App\Models\KnowledgeCafe\Library\Book;


$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(12),
        'author' => $faker->name,
        'isbn' => $faker->ean13,
        'thumbnail' => $faker->imageUrl(),
        'readable_link' => $faker->url,
    ];
});
