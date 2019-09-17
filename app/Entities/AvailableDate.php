<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AvailableDate extends Model
{
    // 資料表名稱
    protected $table = 'available_dates';
    // 主鍵名稱
    public $incrementing = false;
    protected $primaryKey = ['available_date', 'tour_id'];
    protected $fillable = [
        'available_date'
    ];

    public $timestamps = false;

    // public function tour()
    // {
    //     return $this->belongsTo('App\Test_Shop\Tour\Entities\Tour', 'id', 'available_date');
    // }
}
