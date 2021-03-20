<?php

namespace App\Http\Controllers;

use App\Model\DayAddDetail;
use App\Model\DayAddTotal;
use App\Model\ExNickImage;
use App\Model\ImageSpa;
use Illuminate\Http\Request;
use App\Model\NickFb;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\PseudoTypes\True_;

class NickFbController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nickList = DB::table('info_nick_fb')
            ->join('ex_nick_images', 'info_nick_fb.id', '=', 'ex_nick_images.info_nick_fb_id')
            ->join('image_spas', 'ex_nick_images.image_spas_id', '=', 'image_spas.id')
            ->where('info_nick_fb.user_id', Auth::user()->id)
            ->orderBy('info_nick_fb.created_at', 'desc')
            ->get();
        foreach ($nickList as $value) {
            $value->filename = Storage::url($value->filename);
        }
        // dd($nickList);
        return response($nickList);
    }

    public function detailAddDay()
    {
        $nickList = DB::table('info_nick_fb')
            ->where('info_nick_fb.user_id', Auth::user()->id)
            ->where('info_nick_fb.del_active', True)
            ->where('info_nick_fb.status_nick', '1')
            ->orderBy('info_nick_fb.created_at', 'desc')
            ->get();
        return response($nickList);
    }
    public function addDayDetail(Request $request){
        $detailAddDay = DB::table('day_add_friend')
            ->where('day_add_friend.id_create', Auth::user()->id)
            ->where('day_add_friend.date_add',$request->date)
            ->orderBy('day_add_friend.created_at', 'desc')
            ->get();
        return response($detailAddDay);

    }
    public function createAddDay(Request $request)
    {
        $nick = $request->nick_name;
        // dd(Auth::user()->id);
        $dayAddDetail = DayAddDetail::create([
            'nick_name' => $nick["nick_name"],
            'date_add' => $request->date_add,
            'to_number' => $request->to_number,
            'to_number_group' => $request->to_number_group,
            'info_nick_fb_id' => $nick["id"],
            'day_add_total_id' => $request->day_add_total_id,
            'info_employee_id' => $request->info_employee_id,
            'create_by' => Auth::user()->name,
            'id_create' => Auth::user()->id,
        ]);

        $totalDayOld = DayAddTotal::find($request->day_add_total_id);

        $totalDayOld->total_day = $totalDayOld->total_day + $request->to_number;
        $totalDayOld->total_add_group = $totalDayOld->total_add_group + $request->to_number_group;
        $totalDayOld->save();

        $nickOld = NickFb::find($nick["id"]);
        $nickOld->number_friend = $nickOld->number_friend + $request->to_number;
        $nickOld->save();

        return response()->json(['success' => 'You have successfully create daytotal.']);
    }


    public function viewAddDay(Request $request)
    {

        // dd($request->route('id'));
        $viewDay = DB::table('day_add_friend')
            ->where('day_add_friend.day_add_total_id', $request->route('id'))
            ->orderBy('day_add_friend.created_at', 'desc')
            ->get();
        return response($viewDay);
    }

    public function create(Request $request)
    {
    }
    public function store(Request $request)
    {

        // $this->validate($request->images, [

        //     'filename' => 'required',
        //     'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        // ]);
        // dd($request->photos);
        // $nick = new NickFb;
        // $nick->nick_name = $request->username_fb;
        // $nick->url_fb = $request->url_fb;
        // $nick->username_fb = $request->uid;
        // $nick->password_fb = $request->password_fb;
        // $nick->status_nick =true;
        // $nick->number_friend =$request->number_friend;


        // ở đây abh ạ, lưu vào cái store 
        // nay e upload nhieu hinh a` vâng
        // nhiều hình ảnh e cũng làm tương tự nhưng cách lưu vào db sẽ khác vì hiện tại cái này hình ảnh e 
        // đang lưu vào 1 table khác vâng, lưu vào db chỉ cần lưu đường dẫn từ strogare à anh,
        // còn khi lấy ra thì gán url đó vô thẻ img là đc ạ
        // trường hợp khác domain thì e phải response về domain trước đó nữa e, còn cùng domain thi thôi
        //ý là trường hợp tách 2 serve 1 cái lưu file dữ lieuej, còn 1 cái chỉ chạy code thôi ạ
        // không e, 1 cái chạy laravel, 1 cái chạy vue riêng đó e, , à vâng 
        // e thử cái upload avatar xem

        if ($request->hasFile('photos')) {
            // $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            // $files = $request->file('photos');
            // // flag xem có thực hiện lưu DB không. Mặc định là có
            // $exe_flg = true;
            // // kiểm tra tất cả các files xem có đuôi mở rộng đúng không
            // foreach ($files as $file) {
            //     $extension = $file->getClientOriginalExtension();
            //     $check = in_array($extension, $allowedfileExtension);

            //     if (!$check) {
            //         // nếu có file nào không đúng đuôi mở rộng thì đổi flag thành false
            //         $exe_flg = false;
            //         break;
            //     }
            // }
            // // nếu không có file nào vi phạm validate thì tiến hành lưu DB
            // if ($exe_flg) {
                // lưu product
                $nick = NickFb::create([
                    // $request->all(),
                    'nick_name' => $request->nick_name,
                    'url_fb' => $request->url_fb,
                    'username_fb' => $request->username_fb,
                    'password_fb' => $request->password_fb,
                    'status_nick' => "1",
                    'number_friend' => $request->number_friend,
                    'user_id' => Auth::user()->id,
                    'create_by' => Auth::user()->name,
                    'id_create' => Auth::user()->id,
                ]);
                // duyệt từng ảnh và thực hiện lưu
                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $file) {
                        if ($file instanceof UploadedFile) {
                            $nameUrl = time() . '.' . $file->getClientOriginalName();
                            // $filename = $photo->storeAs('photos', $nameUrl);

                            $uploadPath = public_path('upload');
                            $file->move($uploadPath, $nameUrl);
                            $filename = "upload/" . $nameUrl;


                            // $request->file->move(public_path('upload'), $fileName);
                            $image = ImageSpa::create([
                                'filename' => $filename,
                            ]);
                            ExNickImage::create([
                                'image_spas_id' => $image->id,
                                'info_nick_fb_id' => $nick->id,
                            ]);
                        };
                    }
                // }
                echo "Upload successfully";
            } else {
                echo "Falied to upload. Only accept jpg, png photos.";
            }
        }
        return response()->json(['success' => 'You have successfully create nick.']);
    }


    public function show(Request $request)
    {
        //
    }


    public function edit(Request $request)
    {
        //
    }


    public function update(Request $request)
    {
        // $nickOld = NickFb::where('id',$request->id)->get();
        $nickOld = NickFb::find($request->info_nick_fb_id);
        $nickOld->nick_name = $request->nick_name;
        $nickOld->url_fb = $request->url_fb;
        $nickOld->username_fb = $request->username_fb;
        $nickOld->password_fb = $request->password_fb;
        $nickOld->status_nick = $request->status_nick;
        $nickOld->number_friend = $request->number_friend;
        $nickOld->save();
    }

    public function destroy(Request $request)
    {
        //
    }
}
