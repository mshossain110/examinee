<?php

namespace Database\Factories;

use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

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
