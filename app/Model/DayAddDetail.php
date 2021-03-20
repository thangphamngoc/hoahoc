<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DayAddDetail extends Model
{
    protected $table = 'day_add_friend';
    protected $fillable = [
        'nick_name',
        'to_number',
        'to_number_group',
        'info_nick_fb_id',
        'day_add_total_id',
        'create_by',
        'id_create',
        'date_add',
    ];
}
