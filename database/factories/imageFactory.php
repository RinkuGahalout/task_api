<?php

namespace Database\Factories;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class imageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = Image::class;
    public function definition()
    {
        return [
            'image_path' => $this->faker->imageUrl(),
        ];
    }
}
