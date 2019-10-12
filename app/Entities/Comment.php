<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'comments';

    public $incrementing = false;
    protected $primaryKey = ['created_at', 'order_id'];
    protected $fillable = [
        'content',
        'rating',
        'created_at'
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Entities\Order');
    }
}
