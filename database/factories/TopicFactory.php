<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = ['Web Design', 'Laravel', 'Vuejs', 'Javascript', 'Java', 'Angular', 'Mobile Application', 'C#', 'C++', 'Web Application'];
        return [
            'title' => $name[rand(0, 9)],
            'description' => $this->faker->paragraph(),
        ];
    }
}
