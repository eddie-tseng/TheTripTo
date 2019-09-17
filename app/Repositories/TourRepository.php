<?php

namespace App\Repositories;

use App\Entities\Tour;
use Illuminate\Support\Facades\Log;

class TourRepository
{
    public function __construct()
    {
        $this->tour = Tour::query();
    }

    public function get()
    {
        return $this->tour->get();
    }

    public function count()
    {
        return $this->tour->count();
    }

    public function filterByField($column, $operator, $value)
    {
        switch($operator)
        {
            case 'like':
            case '=':
                $this->tour->where($column, $operator, $value);
                break;
            case 'between':
                $this->tour->whereBetween($column, $value);
                break;
            case 'in':
                $this->tour->whereIn($column, $value);
                break;
            default:
                return $this;
            break;
        }
        return $this;

    }

    public function sort($column, $key)
    {
        $this->tour->orderBy($column, $key);

        return $this;
    }

    public function getColumn($filedName)
    {
        return $this->tour->pluck($filedName);
    }

    public function paginate($count)
    {
        return $this->tour->paginate($count);
    }
    // public function getValue($filedName)
    // {
    //     return $this->tour->get($filedName);
    // }

}

