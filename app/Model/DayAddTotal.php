<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DayAddTotal extends Model
{
    protected $table = 'day_add_total';
    protected $fillable = [
        'info_employee_id',
        'id_create',
        'create_by',
        'date_add',
        'total_day',
        'total_add_group'
    ];
}
