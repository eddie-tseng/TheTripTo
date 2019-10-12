<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tourist extends Model
{

    protected $table = 'tourists';

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
