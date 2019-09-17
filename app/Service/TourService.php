<?php

namespace App\Service;
use App\Repositories\TourRepository;
use Illuminate\Support\Facades\Log;

class TourService
{
    function __construct()
    {
        $this->TourRepository = new TourRepository();
    }


    /**
    * 查詢已上架的行程
    *
    * @param array $filterRules $filterRules[column as string, value as array, operator = null as string]
    * @return array
    */
    public function queryTours($filterRules, $sort_column = null, $sort_key = null)
    {
        $this->TourRepository->filterByField('status', '=', 'r');

        foreach ($filterRules as $rule) {
            switch($rule[1])
            {
                case 'like':
                case '=':
                    $this->TourRepository->filterByField($rule[0], $rule[1], $rule[2]);
                    break;
                case 'between':
                case 'in':
                    $this->TourRepository->filterByField($rule[0], $rule[1], $rule[2]);
                    break;
                default:

                break;
            }
            // $this->TourRepository->filterByField($rule[0], $rule[1]);
        }

        if(isset($sort_column) && isset($sort_key))
        {
            $this->TourRepository->sort($sort_column, $sort_key);
        }

        return $this->TourRepository;
    }

    public function get()
    {
        return $this->TourRepository->get();
    }

    public function paginate($count)
    {
        return $this->TourRepository->paginate($count);
    }



}
