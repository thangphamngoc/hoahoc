<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HomePostData extends Model
{
    protected $attributes = [
        'postData'=>'',
        'imageList'=>[],
        'avatarAuthor'=>'',
    ];
}
