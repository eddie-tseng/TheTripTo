<?php

use Illuminate\Database\Seeder;
use App\Entities\Tour;

class TourTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Tour::class, 50)
        ->create()
        ->each(function ($tour) {

            $dates = [];

            for ($i=0; $i < 200; $i++) {
                if(($i+2)%7!=0 && ($i+1)%7!=0)
                {
                    $newDate = \Carbon\Carbon::createFromDate(2019, 8, 12)->addDays($i);
                    array_push($dates, $newDate);
                }
            }

            foreach ($dates as $value) {
                $tour->AvailableDates()->firstOrCreate(['available_date' => $value]);
            }
        });
    }
}
