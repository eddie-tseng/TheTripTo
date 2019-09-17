<?php

namespace App\Repositories;

use App\Entities\AvailableDate;

class AvailableDateRepository
{
    public function __construct()
    {
        $this->availableDate = AvailableDate::query();
    }

    // public function getDatesCount($tourId)
    // {
    //     return $this->availableDate
    //         ->where('tour_id', $tourId)->count();
    // }
    public function get()
    {
        return $this->availableDate->get();
    }

    public function count()
    {
        return $this->availableDate->count();
    }

    public function filterByField($fieldName, $criteria)
    {
        $this->availableDate->where($fieldName, $criteria);
        return $this;
    }


    public function getColumn($filedName)
    {
        return $this->availableDate->pluck($filedName);
    }

    // public function getDates($tourId)
    // {
    //     return $this->availableDate
    //         ->where('tour_id', $tourId)->get();
    // }

}
