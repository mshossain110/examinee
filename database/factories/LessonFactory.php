<?php

use Illuminate\Support\Str;

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
$factory->define(App\Lesson::class, function (Faker\Generator $faker) {
    $name = $faker->text(50);
    return [
        'title' => $name,
        'thumbnail' => $faker->imageUrl($width = 640, $height = 480),
        'slug' => Str::slug($name),
        'short_text' => $faker->paragraph(),
        'full_text' => $faker->text(1000),
        'position' => rand(1, 10),
        'status' => rand(1, 3),
        'created_by' => rand(1, 5),
        'updated_by' => rand(1, 5),
    ];
});
