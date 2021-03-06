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


        // ??? ????y abh ???, l??u v??o c??i store 
        // nay e upload nhieu hinh a` v??ng
        // nhi???u h??nh ???nh e c??ng l??m t????ng t??? nh??ng c??ch l??u v??o db s??? kh??c v?? hi???n t???i c??i n??y h??nh ???nh e 
        // ??ang l??u v??o 1 table kh??c v??ng, l??u v??o db ch??? c???n l??u ???????ng d???n t??? strogare ?? anh,
        // c??n khi l???y ra th?? g??n url ???? v?? th??? img l?? ??c ???
        // tr?????ng h???p kh??c domain th?? e ph???i response v??? domain tr?????c ???? n???a e, c??n c??ng domain thi th??i
        //?? l?? tr?????ng h???p t??ch 2 serve 1 c??i l??u file d??? lieuej, c??n 1 c??i ch??? ch???y code th??i ???
        // kh??ng e, 1 c??i ch???y laravel, 1 c??i ch???y vue ri??ng ???? e, , ?? v??ng 
        // e th??? c??i upload avatar xem

        if ($request->hasFile('photos')) {
            // $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            // $files = $request->file('photos');
            // // flag xem c?? th???c hi???n l??u DB kh??ng. M???c ?????nh l?? c??
            // $exe_flg = true;
            // // ki???m tra t???t c??? c??c files xem c?? ??u??i m??? r???ng ????ng kh??ng
            // foreach ($files as $file) {
            //     $extension = $file->getClientOriginalExtension();
            //     $check = in_array($extension, $allowedfileExtension);

            //     if (!$check) {
            //         // n???u c?? file n??o kh??ng ????ng ??u??i m??? r???ng th?? ?????i flag th??nh false
            //         $exe_flg = false;
            //         break;
            //     }
            // }
            // // n???u kh??ng c?? file n??o vi ph???m validate th?? ti???n h??nh l??u DB
            // if ($exe_flg) {
                // l??u product
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
                // duy???t t???ng ???nh v?? th???c hi???n l??u
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
