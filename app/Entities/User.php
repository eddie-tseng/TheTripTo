<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 資料表名稱
    protected $table = 'users';
    // 主鍵名稱
    protected $primaryKey = 'id';
    // 可以大量指定異動的欄位（Mass Assignment）
    protected $fillable = [
        'account',
        'fb_account',
        'password',
        'first_name',
        'last_name',
        'photo',
        'gender',
        'birth_date',
        'mail',
        'phone',
        'country'
    ];

    //public $timestamps = false;
    //protected $dateFormat = 'U';

    public function orders()
    {
        return $this->hasMany('App\Entities\Order');
    }

    // public function commennts()
    // {
    //     return $this->hasMany('App\Entities\Comment');
    // }

    public function favoriteTours()
    {
        return $this->belongsToMany('App\Entities\Tour', 'favorite_tours')->withTimestamps();
    }

    public function browsingHistorys()
    {
        return $this->belongsToMany('App\Entities\Tour', 'browsing_historys')->withTimestamps();
    }
}
