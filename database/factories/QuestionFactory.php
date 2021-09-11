<?php

namespace Database\Factories;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

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
