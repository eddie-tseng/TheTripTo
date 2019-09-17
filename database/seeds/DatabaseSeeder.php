<?php

use Illuminate\Database\Seeder;
use App\Repositories\TourRepository;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TourTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(OrderTableSeeder::class);

    }
}
