<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Tourist;

use Faker\Generator as Faker;

$factory->define(Tourist::class, function (Faker $faker) {

    $gender = ['m','f'];

    return [
        'first_name' => $faker->firstName,
        'last_name'=> $faker->lastName,
        'mail' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'country' => $faker->country,
        'birth_date' => $faker->date('Y-m-d','now'),
        'gender'=> $faker->randomElement($gender),
    ];
});
