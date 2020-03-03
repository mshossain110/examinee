<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\User::class, function (Faker $faker) {
    return [
        'firstname'      => $faker->firstName ,
        'lastname'       => $faker->lastName,
        'avatar'         => 'http://lorempixel.com/80/60/',
        'name'           => $faker->unique()->userName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => '$2y$10$l4MghrLnKXTRUDlR07XQeesKHRIaAe7WzDf90g751BEf70AwnJ5m.',// password
        'ip'             => $faker->ipv6,
    ];
});
