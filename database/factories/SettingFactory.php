<?php
namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Setting;

$factory->define(Setting::class, function (Faker $faker) {
    $modules = config('constants.modules');
    return [
        'module' => $modules[array_rand($modules)],
        'setting_key' => $faker->slug,
        'setting_value' => $faker->sentence,
    ];
});
