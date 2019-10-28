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
$factory->define(App\Topic::class, function (Faker\Generator $faker) {
    $name = ['Web Design', 'Laravel', 'Vuejs', 'Javascript', 'Java', 'Angular', 'Mobile Application', 'C#', 'C++', 'Web Application'];
    return [
        'title' => $name[rand(0, 9)],
        'description' => $faker->paragraph(),
    ];
});
