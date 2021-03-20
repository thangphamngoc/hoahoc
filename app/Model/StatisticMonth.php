<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatisticMonth extends Model
{
    protected $attributes = [
        'infoEmployee'=>"",
        'nickList'=>"",
        'dayTotal'=>"",
        'dayDetail'=>"",
        'numberDayNo'=>0,
        'numberAdd'=>0,
        'numberDay'=>0,
    ];
}
