<?php

namespace App\Http\Controllers;

use App\Model\InfoEmployee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InfoEmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $nickList = DB::table('info_employee')
        ->where('info_employee.app_type', Config::get('constants.app_type.employee'))
        ->orderBy('full_name')->get(); 

        foreach ($nickList as $value) {
            $value->avatar = Storage::url($value->avatar);
        }
        // dd($nickList);
        return response($nickList);
    }



    
    public function store(Request $request)
    {
        $userCheck = User::where('email', $request->email)->get();
        if ($userCheck) {
            $user = User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => bcrypt($request->phone),
                'create_by' => Auth::user()->name,
                'id_create' => Auth::user()->id,
                'app_type' => Config::get('constants.app_type.employee'),
                'password_show' => $request->phone,
                'gender' => 'Male',
                'phone' => $request->phone,
            ]);
            $info = InfoEmployee::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'bank' => $request->bank,
                'create_by' => Auth::user()->name,
                'id_create' => Auth::user()->id,
                'birthday' => '2021-01-01',
                'code' => 'code',
                'education_level' => $request->education_level,
                'facebook' => $request->facebook,
                'address' => $request->address,
                'app_type' => Config::get('constants.app_type.employee'),
                'employee_status' => '1',
                'gender' => 'Male',
                'phone' => $request->phone,
                'user_id' => $user->id,
                // 'school_id' => 1,
            ]);

            // đoạn này em lấy avater là tên ảnh để lưu vao
            $info->uploadProfilePhoto($request->file('avatar'));
            
        } else {
            return response()->json(['success' => 'Email đã được đăng kí trong hệ thống.']);
        }
        return response()->json(['success' => 'You have successfully create nick.']);
    }


    public function update(Request $request)
    {
        $this->validate($request,[
            'avatar' => ['nullable', 'image', 'mimes:jpg,png,jpge']
        ]);
        // $nickOld = NickFb::where('id',$request->id)->get();
        // dd($request->all());
        $infoOld = InfoEmployee::find($request->id);
        $infoOld->full_name = $request->full_name;
        $infoOld->facebook = $request->facebook;
        $infoOld->bank = $request->bank;
        $infoOld->birthday = $request->birthday;
        $infoOld->education_level = $request->education_level;
        $infoOld->address = $request->address;
        $infoOld->employee_status = $request->employee_status;
        $infoOld->gender = $request->gender;
        $infoOld->phone = $request->phone;
        $infoOld->uploadProfilePhoto($request->file('avatar'));
        $infoOld->save();
        // cái này do client gửi lên ko phải file, phải dùng form data gửi lên nha e
    }
}
