<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Entities\User;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    if(!File::exists(public_path()."/img/user")){
        File::makeDirectory(public_path()."/img/user");
    }

    $mail = $faker->unique()->safeEmail;
    $gender = ['m','f'];
    $image = $faker->image('public/img/user',150,150,'people',false);

    return [
        'account' => $mail,
        'google_account'=> $faker->randomNumber(8),
        'mail' => $mail,
        'password'=>'$2y$10$mtaB9NlKZxXolSZ6HPtCLuaYbmuPZRHLxzMHc00X/0YXXDh9f5rLy', //88888888
        'photo'=> 'img/user/'.$image,
        'first_name' => $faker->firstName,
        'last_name'=> $faker->lastName,
        'phone' => $faker->phoneNumber,
        'country' => $faker->country,
        'birth_date' => $faker->date('Y-m-d','now'),
        'gender'=> $faker->randomElement($gender),
    ];
});
