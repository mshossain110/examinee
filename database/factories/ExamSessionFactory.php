<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class ExamSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = ['Intruduction', 'Basic', 'Get into Deep', 'Advance',  'Example', 'Practices'];
        return [
            'title' => $name[rand(0, 5)],
            'description' => $this->faker->paragraph(),
        ];
    }
}
