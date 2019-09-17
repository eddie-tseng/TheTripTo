<?php

namespace App\Repositories;

use App\Entities\User;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    public function __construct()
    {
        $this->user = User::query();
    }

    public function get()
    {
        return $this->user->get();
    }

    public function count()
    {
        return $this->user->count();
    }

    public function filterByField($fieldName, $criteria)
    {
        $this->user->where($fieldName, $criteria);
        return $this;
    }

    public function getColumn($filedName)
    {
        return $this->user->pluck($filedName);
    }
}

