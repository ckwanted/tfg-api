<?php

use Faker\Generator as Faker;

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
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => 'secret',
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'admin', function ($faker) {
    $user = $this->raw(App\User::class);
    return array_merge($user, ['email' => 'admin@tfg.com']);
});
