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
$factory->define(App\Exam::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->sentence(6),
        'description' => $faker->paragraph(),
        'examiner' => rand(1, 10),
        'status' => rand(1, 4),
        'price' => 100,
        'duration' => rand(30, 150),
        'pass_mark' => 20,
        'number_of_questions'=> 10,
        'certification' => false,
    ];
});
