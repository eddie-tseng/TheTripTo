<?php

namespace App\Repositories;

use App\Entities\Tourist;
use Illuminate\Support\Facades\Log;

class TouristRepository
{
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = Tourist::query();
    }

    public function get()
    {
        return $this->queryBuilder->get();
    }

    public function count()
    {
        return $this->queryBuilder->count();
    }

    public function filterByField($column, $operator, $value)
    {
        switch($operator)
        {
            case 'like':
            case '=':
                $this->queryBuilder->where($column, $operator, $value);
                break;
            case 'between':
                $this->queryBuilder->whereBetween($column, $value);
                break;
            case 'in':
                $this->queryBuilder->whereIn($column, $value);
                break;
            default:
                return $this;
            break;
        }
        return $this;

    }

    public function sort($column, $key)
    {
        $this->queryBuilder->orderBy($column, $key);

        return $this;
    }

    public function getColumn($filedName)
    {
        return $this->queryBuilder->pluck($filedName);
    }

    public function paginate($count)
    {
        return $this->queryBuilder->paginate($count);
    }


}

