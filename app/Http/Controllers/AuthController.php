<?php

namespace App\Http\Controllers;

use App\Models\touchstarClient;
use App\Models\touchStarEmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function LoginForm()
    {
        return view('auth.login');
    }
    public function LoginAuth(Request $req){
        $email = $req->input('email');
        $password = $req->input('password');
        if(Auth::guard('touchstaraccount')->attempt(['touch_acc_email' => $email, 'password' => $password])){
            if(Auth::guard('touchstaraccount')->user()->touch_acc_login_status != "DISABLED"){
                return Response::redirectTo("/machine");
            }else{
                Auth::guard('touchstaraccount')->logout();
                return redirect("login")->with("disableaccount",true);
            }
        }else{
            return redirect("login")->with("noaccount",true);
        }
    }

    public function client(){
        $employee_details = touchStarEmp::where('emp_id', Auth::guard('touchstaraccount')->user()->emp_id)->first();
        $client_details = touchstarClient::all();
        return view('clientauth.register',compact('employee_details','client_details'));
    }
    public function clientAuth(){
        Auth::guard("touchstaraclientccount")->attempt();
        return "awda";
    }
}

