<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{

    protected $table = 'tours';

    protected $primaryKey = 'id';

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

    public function scopePopular($query)
    {
        return $query->orderBy('id', 'asc')->limit(24);
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereType($type);
    }

}
