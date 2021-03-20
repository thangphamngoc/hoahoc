<?php

namespace App\Http\Controllers;

use App\Model\DayAddTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TotalDayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nickList = DB::table('info_employee')
        ->join('day_add_total','day_add_total.info_employee_id','=','info_employee.id')
        ->where('info_employee.user_id',Auth::user()->id)
        ->orderBy('day_add_total.date_add', 'desc')
        ->get();
        // dd($nickList);
        return response($nickList);
    }

    public function store(Request $request)
    {
        // $userCheck = DayAddTotal::where('email', $request->email)->get();
        // dd($request->all());
            $dayAddTotal = DayAddTotal::create([
                'date_add' => $request->date,
                'create_by' => Auth::user()->name,
                'id_create' => Auth::user()->id,
                'total_day' => 0,
                'total_add_group' => 0,
                'info_employee_id' => $request->id,
            ]);

        return response()->json(['success' => 'You have successfully create daytotal.']);
    }


    public function update(Request $request)
    {
        // $nickOld = NickFb::where('id',$request->id)->get();
        // dd($request->all());
        $infoOld = DayAddTotal::find($request->id);
        // $infoOld->full_name = $request->full_name;
        // $infoOld->facebook = $request->facebook;
        // $infoOld->bank = $request->bank;
        // $infoOld->birthday = $request->birthday;
        // $infoOld->education_level = $request->education_level;
        // $infoOld->address = $request->address;
        // $infoOld->employee_status = $request->employee_status;
        // $infoOld->gender = $request->gender;
        // $infoOld->phone = $request->phone;
        // $infoOld->save();
    }
}
