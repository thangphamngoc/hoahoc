<?php

namespace App\Http\Controllers;

use App\Model\Home;
use App\Model\HomePostData;
use App\Model\InfoEmployee;
use App\Model\NickFb;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function staticsAdd()
    {

        $now = Carbon::now();

        $endMonth = $now->endOfMonth()->day;
        if ((Auth::user()->app_type) =='EMPLOYEE') {

            $info = InfoEmployee::where('user_id', Auth::user()->id)->first()->id;
            $nickList = NickFb::where('user_id', Auth::user()->id)->count();
            if ($nickList > 0) {
                $numberDay = DB::table('day_add_total')
                    ->whereMonth('date_add', $now->month)
                    ->whereYear('date_add', $now->year)
                    ->where('del_active', true)
                    ->where('info_employee_id', $info)
                    ->get('total_day')->count();


                $numberAdd = DB::table('day_add_total')
                    ->whereMonth('date_add', $now->month)
                    ->whereYear('date_add', $now->year)
                    ->where('del_active', true)
                    ->where('info_employee_id', $info)
                    ->sum('total_day');


                $numberDayNo = $endMonth -  $numberDay;
                $modelHome = new Home;
                $modelHome->numerNick = $nickList;
                $modelHome->numberAdd = $numberAdd;
                $modelHome->numberDayAdd = $numberDay;
                $modelHome->numberdayNoAdd = $numberDayNo;
                return response($modelHome);
            }


        } else return new Home;
    }
    public function searchPost()
    {

        $postList = DB::table('posts')
            ->where('posts.del_active', true)
            ->orderBy('posts.created_at', 'desc')
            ->get();


        $reponseList = array();

        foreach ($postList as $value) {

            $images = DB::table('image_spas')
                ->join('ex_post_images', 'image_spas.id', '=', 'ex_post_images.image_spas_id')
                ->where('ex_post_images.post_id', $value->id)
                ->get();

            

            $data = new HomePostData;
            $data->avatarAuthor = User::find($value->user_id)->photo_url;
            $data->postData = $value;
            // foreach ($images as $value) {
            //     $value->filename = Storage::url($value->filename);
            // }
            $data->imageList = $images;
           
            array_push($reponseList, $data);
        }
        return response($reponseList);
    }
}
