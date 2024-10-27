<?php
namespace Modules\HR\Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrResourcesCategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->name,
            'slug' => 'interview-guidelines',

        ];
    }
}
