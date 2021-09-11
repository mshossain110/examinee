<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->text(50);
        return [
            'title' => $name,
            'thumbnail' => $this->faker->imageUrl($width = 640, $height = 480),
            'slug' => Str::slug($name),
            'short_text' => $this->faker->paragraph(),
            'full_text' => $this->faker->text(1000),
            'position' => rand(1, 10),
            'status' => rand(1, 3),
            'created_by' => rand(1, 5),
            'updated_by' => rand(1, 5),
        ];
    }
}
