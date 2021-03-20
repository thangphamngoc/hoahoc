<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImageSpa extends Model
{
    public function nickfb()
    {
        return $this->belongsTo('App\NickFb');
    }

    protected $table = 'image_spas';
    protected $fillable = ['filename','info_nick_fb_id'];

}
