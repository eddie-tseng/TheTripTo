<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AvailableDate extends Model
{
    protected $table = 'available_dates';

    public $incrementing = false;

    protected $primaryKey = ['available_date', 'tour_id'];

    protected $fillable = [
        'available_date'
    ];

    public $timestamps = false;
}
