<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tourist extends Model
{
    // 資料表名稱
    protected $table = 'tourists';
    // 主鍵名稱
    public $incrementing = false;
    protected $primaryKey = ['first_name', 'last_name', 'order_id'];
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'mail',
        'phone',
        'country',
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Entities\Order');
    }
}
