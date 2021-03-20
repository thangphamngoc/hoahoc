<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExNickImage extends Model
{
    protected $table = 'ex_nick_images';
    protected $fillable = ['image_spas_id','info_nick_fb_id'];
}
