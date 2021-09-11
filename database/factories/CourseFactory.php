<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

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
