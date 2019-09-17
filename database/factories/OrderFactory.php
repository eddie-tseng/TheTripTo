<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Order;
use App\Repositories\TourRepository;
use App\Repositories\UserRepository;
use App\Service\AvailableDateService;
use Illuminate\Support\Facades\Log;

use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $tourRepository = new TourRepository();
    $availableDateService = new AvailableDateService();
    $userRepository = new UserRepository();

    $status = ['r'];
    $payment = ['wt', 'cc'];
    $quantity = $faker->numberBetween(1, 4);
    $tour_id = $faker->numberBetween(1, $tourRepository->count());
    $user_id = $faker->numberBetween(1, $userRepository->count());
    return [
        'status' => $faker->randomElement($status),
        'travel_date' => $availableDateService->getRandomDate($tour_id),
        'quantity' => $quantity,
        'price' => $tourRepository->filterByField('id','=', $tour_id)->getColumn('price')->first()*$quantity,
        'payment' => $faker->randomElement($payment),
        'tour_id' => $tour_id,
        'user_id' => $user_id,
    ];
});
