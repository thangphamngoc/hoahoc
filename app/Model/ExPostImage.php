<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExPostImage extends Model
{
    protected $table = 'ex_post_images';
    protected $fillable = [
        'post_id',
        'image_spas_id',
    ];
}
