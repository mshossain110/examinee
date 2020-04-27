<?php

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
    
    return [
        'created_by' => rand(1, 10),
        'question' => $faker->sentence(10),
        'options' => ['true', 'false', 'both', 'non'],
        'answer' => 'true',
        'hint' => 'Answer always true',
        'explanation' => 'you are giving answer form faker generate question',
        'exam_id' => rand(1, 10),
    ];
});
