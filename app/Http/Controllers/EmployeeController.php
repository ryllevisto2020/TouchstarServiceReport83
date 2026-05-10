<?php

namespace App\Http\Controllers;

use App\Models\touchStarEmp;
use App\Models\touchstarUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    //
    public function index(){
        $employee_details = touchStarEmp::where('emp_id', Auth::guard('touchstaraccount')->user()->emp_id)->first();
        $employees = touchStarEmp::all();
        $empUser = touchstarUser::all();
        return view('auth.register',compact('employee_details', 'employees','empUser'));
    }

    public function addData(Request $req){
        touchStarEmp::create([
            'emp_first_name' => $req->input('firstName'),
            'emp_last_name' => $req->input('lastName'),
            'emp_phone' => $req->input('phone'),
            'emp_viber' => $req->input('viber'),
            'emp_socmed' => $req->input('social'),
            'emp_deparment' => $req->input('dept'),
            'emp_position' => $req->input('position'),
            'emp_role' => "EMPLOYEE",
            'emp_signature' => $req->input('signature'),
            'emp_status' => $req->input('status'),
            'emp_profile'=>$req->input('profilePic')   
        ])->save();
        return response()->json(['message' => 'Employee added successfully']);
    }

    public function addAccount(Request $req){
        touchstarUser::create([
            'emp_id'=>$req->empId,
            'touch_acc_username'=>$req->user,
            'touch_acc_email'=>$req->email,
            'password'=>Hash::make($req->password)
        ])->save();
        touchStarEmp::find($req->empId,'*')->update([
            'emp_account'=>"TRUE"
        ]);
        return response()->json(["status"=>200]);
    }
}
