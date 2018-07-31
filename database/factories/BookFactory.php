<?php

use Faker\Generator as Faker;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\KnowledgeCafe\Library\BookCategory;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(12),
        'author' => $faker->name,
        'isbn' => $faker->ean13,
        'thumbnail' => $faker->imageUrl(),
        'readable_link' => $faker->url,
    ];
});

$factory->define(BookCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(10)
    ];
});
