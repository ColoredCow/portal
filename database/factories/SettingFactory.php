<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $modules = config('constants.modules');

        return [
            'module' => $modules[array_rand($modules)],
            'setting_key' => $this->faker->slug,
            'setting_value' => $this->faker->sentence,
        ];
    }
}
