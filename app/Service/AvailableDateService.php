<?php

namespace App\Service;
use App\Repositories\AvailableDateRepository;
use Illuminate\Support\Facades\Log;

class AvailableDateService
{
    function __construct()
    {
        $this->availableDateRepository = new AvailableDateRepository();
    }

    public function getValue($filedName)
    {
        return $this->availableDateRepository->get($filedName);
    }

    public function getRandomDate($tourId)
    {
        $dates = [];
        $dates = $this->availableDateRepository->filterByField('tour_id', $tourId)->getColumn('available_date');

        return $dates->random();
    }


}
