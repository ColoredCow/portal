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
                'id' => null,
                'event_name' => 'new1',
                'img_url' => 'img.jpg',
                'uploaded_by' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
                'description' => 'new img',
            ])
        ];
    }
}
