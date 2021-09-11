<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

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
