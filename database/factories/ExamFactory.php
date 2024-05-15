<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'examiner' => rand(1, 10),
            'status' => rand(1, 4),
            'price' => 100,
            'duration' => rand(30, 150),
            'pass_mark' => 20,
            'number_of_questions' => 10,
            'certification' => false,
        ];
    }
}
