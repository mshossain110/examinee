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
$factory->define(App\Session::class, function (Faker\Generator $faker) {
    $name = ['Intruduction', 'Basic', 'Get into Deep', 'Advance',  'Example', 'Practices'];
    return [
        'title' => $name[rand(0, 5)],
        'description' => $faker->paragraph(),
    ];
});
