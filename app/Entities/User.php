<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'account',
        'google_account',
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

    public function orders()
    {
        return $this->hasMany('App\Entities\Order');
    }

    public function favoriteTours()
    {
        return $this->belongsToMany('App\Entities\Tour', 'favorite_tours')->withTimestamps();
    }

    public function browsingHistorys()
    {
        return $this->belongsToMany('App\Entities\Tour', 'browsing_historys')->withTimestamps();
    }
}
