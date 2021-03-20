<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class InfoEmployee extends Model
{
    protected $table = 'info_employee';
    protected $fillable = ['full_name','email','bank','birthday','code','education_level','facebook','address','app_type','employee_status','gender','phone','user_id'];
    /**
     * @param \Illuminate\Http\UploadedFile|null $photo
     */
    public function uploadProfilePhoto($photo){
        if($photo instanceof UploadedFile){
            tap($this->avatar, function($prev) use($photo){
                // Luu database voi user goi ham nay
                $this->forceFill([
                    // cho nay upload hinh anh vao storage/app/public/avatars
                    'avatar' => $photo->storePublicly(
                        'avatars',
                        [
                            'disk' => 'public'
                        ]
                    )
                ]);
                // cai nay cho truong hop doi avatar moi se xoa avatar cu di
    // neeus lưu nhiều ảnh thì foreach gọi hàm này à anh
                if($prev){
                    Storage::disk('public')->delete($prev);
                }
            });
        }
    }
}
