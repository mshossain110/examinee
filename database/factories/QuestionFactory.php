<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $answer = Carbon::now()->isoFormat("x") . '-' . rand(100, 999);
        return [
            'created_by' => rand(1, 10),
            'question' => $this->faker->sentence(10),
            'options' => [
                [
                    'option' => 'true',
                    'id' => $answer
                ],
                [
                    'option' => 'false',
                    'id' => Carbon::now()->isoFormat("x") . '-' . rand(100, 999)
                ],
                [
                    'option' => 'both',
                    'id' => Carbon::now()->isoFormat("x") . '-' . rand(100, 999)
                ],
                [
                    'option' => 'non',
                    'id' => Carbon::now()->isoFormat("x") . '-' . rand(100, 999)
                ]
            ],
            'answer' => [$answer],
            'hint' => 'Answer always true',
            'explanation' => 'you are giving answer form faker generate question',
            'exam_id' => rand(1, 10),
        ];
    }
}
