<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Question::class, function (Faker\Generator $faker) {
    $answer = Carbon::now()->isoFormat("x").'-'.rand(100, 999);
    return [
        'created_by' => rand(1, 10),
        'question' => $faker->sentence(10),
        'options' => [
            [
                'option' => 'true',
                'id' => $answer
            ],
            [
                'option' => 'false',
                'id' => Carbon::now()->isoFormat("x").'-'.rand(100, 999)
            ],
            [
                'option' => 'both',
                'id' => Carbon::now()->isoFormat("x").'-'.rand(100, 999)
            ],
            [
                'option' => 'non',
                'id' => Carbon::now()->isoFormat("x").'-'.rand(100, 999)
            ]
        ],
        'answer' => [$answer],
        'hint' => 'Answer always true',
        'explanation' => 'you are giving answer form faker generate question',
        'exam_id' => rand(1, 10),
    ];
});
