<?php

namespace Modules\Media\Database\factories;

use Modules\Media\Entities\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            \DB::table('media')->insert([
                0 => [
                    'id' => 1,
                    'event_name' => "new1",
                    'img_url' => "img.jpg",
                    'uploaded_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => now(),
                    'description' => "new img",
                ],
                1 => [
                    'id' => 2,
                    'event_name' => "new2",
                    'img_url' => "img.jpg",
                    'uploaded_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => now(),
                    'description' => "new img",
                ],
            ])
        ];
    }
}
