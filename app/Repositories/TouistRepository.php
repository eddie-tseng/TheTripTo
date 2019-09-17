<?php

namespace App\Repositories;

use App\Entities\Tourist;
use Illuminate\Support\Facades\Log;

class TouristRepository
{
    public function __construct()
    {
        $this->tourist = Tourist::query();
    }

    public function get()
    {
        return $this->tourist->get();
    }

    public function getColumn($filedName)
    {
        return $this->tourist->pluck($filedName);
    }

    public function count()
    {
        return $this->tourist->count();
    }


    public function filterByField($fieldName, $criteria)
    {
        $this->tourist->where($fieldName, $criteria);
        return $this;
    }


}

