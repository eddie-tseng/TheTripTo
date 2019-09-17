<?php

namespace App\Repositories;

use App\Entities\Comment;
use Illuminate\Support\Facades\Log;

class CommentRepository
{
    protected $comment;

    public function __construct()
    {
        $this->comment = Comment::query();
    }

    public function get()
    {
        return $this->comment->get();
    }

    public function count()
    {
        return $this->comment->count();
    }

    public function filterByField($fieldName, $criteria)
    {
        $this->comment->where($fieldName, $criteria);
        return $this;
    }

    public function getColumn($filedName)
    {
        return $this->comment->pluck($filedName);
    }

    // public function getValue($filedName)
    // {
    //     return $this->tour->get($filedName);
    // }

}

