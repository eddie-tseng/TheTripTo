<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    // 資料表名稱
    protected $table = 'tours';
    // 主鍵名稱
    protected $primaryKey = 'id';
    // 可以大量指定異動的欄位（Mass Assignment）
    protected $fillable = [
        'title',
        'photo',
        'introduction',
        'sub_title',
        'price',
        'inventory',
        'rating',
        'country',
        'city',
        'latitude', //緯度
        'longitude', //經度
        'status'
    ];

    //public $timestamps = false;
    //protected $dateFormat = 'U';

    public function AvailableDates()
    {
        return $this->hasMany('App\Entities\AvailableDate');
    }

    public function orders()
    {
        return $this->hasMany('App\Entities\Order');
    }

    public function favoriteTours()
    {
        return $this->belongsToMany('App\Entities\User', 'favorite_tours')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasManyThrough('App\Entities\Comment', 'App\Entities\Order');
    }

    // public function users()
    // {
    //     return $this->belongsToMany('App\Entities\User', 'favorite_tours');
    // }

    public function scopePopular($query)
    {
        return $query->orderBy('id', 'asc')->limit(24);
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereType($type);
    }

}
