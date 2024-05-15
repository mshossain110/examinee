<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(6);
        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 0, 199),
            'thumbnail' => $this->faker->imageUrl($width = 640, $height = 480),
            'status' => 1,
            'created_by' => rand(1, 5),
            'updated_by' => rand(1, 5),
        ];
    }
}
