<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Repositories\TourRepository;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 15)
            ->create()
            ->each( function($user){
                $tourRepository = new TourRepository();
                $tourIds = $tourRepository->getColumn('id');

                for($i=rand(0, $tourIds->count()); $i<$tourIds->count(); $i+=rand(1,10))
                {
                    $user->favoriteTours()->attach( $tourIds[$i]);
                    $user->browsingHistorys()->attach( $tourIds[$i]);
                }

            });
    }
}
