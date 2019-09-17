<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 資料表名稱
    protected $table = 'orders';
    // 主鍵名稱
    protected $primaryKey = 'id';
    // 可以大量指定異動的欄位（Mass Assignment）
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
