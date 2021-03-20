<?php

namespace App\Http\Controllers;

use App\Model\DayAddDetail;
use App\Model\DayAddTotal;
use App\Model\InfoEmployee;
use App\Model\NickFb;
use App\Model\StatisticMonth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexMonth(Request $request)
    {
        $now = Carbon::now();

        $endMonth = $now->endOfMonth()->day;

        if ((Auth::user()->app_type) == 'SYS' || (Auth::user()->app_type) == 'PLUS') {
            $reponseList = array();
            $infolist = InfoEmployee::where('del_active', true)->get();
            foreach ($infolist as $value) {
                $nickList = NickFb::where('user_id', $value->user_id)->get();
                $dayTotal = DayAddTotal::where('info_employee_id', $value->id)
                    ->where('date_add', $request->date)->get();






                $numberDay = DB::table('day_add_total')
                    ->whereMonth('date_add', $now->month)
                    ->whereYear('date_add', $now->year)
                    ->where('del_active', true)
                    ->where('info_employee_id', $value->id)
                    ->get('total_day')->count();


                $numberAdd = DB::table('day_add_total')
                    ->whereMonth('date_add', $now->month)
                    ->whereYear('date_add', $now->year)
                    ->where('del_active', true)
                    ->where('info_employee_id', $value->id)
                    ->sum('total_day');


                $numberDayNo = $endMonth -  $numberDay;






                $data = new StatisticMonth;
                $data->infoEmployee = $value;
                $data->nickList = $nickList;
                $data->dayTotal = $dayTotal;
                $data->numberDay = $numberDay;
                $data->numberAdd = $numberAdd;
                $data->numberDayNo = $numberDayNo;

                if (count($dayTotal) > 0) {
                    $dayDetail = DayAddDetail::where('day_add_total_id', $dayTotal[0]->id)->get();
                    $data->dayDetail = $dayDetail;
                }
                array_push($reponseList, $data);
            }
            return response($reponseList);
        }
    }
}
