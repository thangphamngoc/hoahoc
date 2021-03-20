<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NickFb extends Model
{
    public function tags()
    {
        return $this->morphToMany(ExNickImage::class, 'taggable');
    }
    protected $table = 'info_nick_fb';

    protected $fillable = ['id_create','nick_name','url_fb','username_fb','password_fb','status_nick','number_friend','user_id','image_fb','create_by'];
}
