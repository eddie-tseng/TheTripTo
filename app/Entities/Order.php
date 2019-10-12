<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'status', //c:create, r:ready, u:used, d:delete
        'travel_date',
        'quantity',
        'price',
        'payment', //wt: wire-transfer, cc: credit-card
    ];

    public function tourists()
    {
        return $this->hasMany('App\Entities\Tourist');
    }

    public function comment()
    {
        return $this->hasone('App\Entities\Comment');
    }


    public function tour()
    {
        return $this->belongsTo('App\Entities\Tour');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }


}
