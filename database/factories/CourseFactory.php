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
$factory->define(App\Course::class, function (Faker\Generator $faker) {
    $name = $faker->sentence(6);
    return [
        'title' => $name,
        'slug' => Str::slug($name),
        'description' => $faker->text(),
        'price' => $faker->randomFloat(2, 0, 199),
        'thumbnail' => $faker->imageUrl($width = 640, $height = 480),
        'status' => 1,
        'created_by' => rand(1, 5),
        'updated_by' => rand(1, 5),
    ];
});
