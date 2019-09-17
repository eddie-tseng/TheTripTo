<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Comment;

use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {

    return [
        'content' =>  $faker->realText($faker->numberBetween(200,400)),
        'rating'=> $faker->numberBetween(1, 5),
        'created_at' => $faker->dateTimeBetween('+6 months','+1 year'),
    ];
});
