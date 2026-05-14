<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MachineController;

use App\Http\Controllers\ServiceController;
use App\Http\Middleware\isAuthEmployee;
use App\Http\Middleware\isLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

Route::get("/",function(){
    return Response::redirectGuest("/login");
});

#Login Routes
Route::get('/login', [AuthController::class, 'LoginForm'])->name('login')->middleware(isLogin::class);
Route::post('/login/auth',[AuthController::class, 'LoginAuth'])->name('login.auth');

#Logout Route
Route::post("/logout",function(Request $request){
    if(Auth::guard('touchstaraccount')->check()){
        Auth::guard('touchstaraccount')->logout();
        return redirect()->route('login');
    }else{
        return Response('Unauthorized', 401);
    }
})->name('logout');
    
#Employee Routes
Route::get('/employee/register', [EmployeeController::class, 'index'])->name('employee.register')->middleware([isAuthEmployee::class]);
Route::post("/employee/add",[EmployeeController::class, 'addData'])->name('employee.add')->middleware([isAuthEmployee::class]);
Route::post("/employee/account/add",[EmployeeController::class,'addAccount'])->name('employee.account.add')->middleware([isAuthEmployee::class]);

#Machine Routes
Route::get('/machine', [MachineController::class, 'index'])->name('machines.index')->middleware([isAuthEmployee::class]);
Route::post('/machine', [MachineController::class, 'store'])->name('machines.store')->middleware([isAuthEmployee::class]);
Route::get('/machine/{machine}/details', [MachineController::class, 'getMachineDetails'])->name('machines.details')->middleware([isAuthEmployee::class]);
Route::get('/machine/{machine}/edit', [MachineController::class, 'edit'])->name('machines.edit')->middleware([isAuthEmployee::class]);
Route::put('/machine/{machine}', [MachineController::class, 'update'])->name('machines.update')->middleware([isAuthEmployee::class]);
Route::delete('/machine/{machine}', [MachineController::class, 'destroy'])->name('machines.destroy')->middleware([isAuthEmployee::class]);

#Service Report Routes
Route::get('/service', [ServiceController::class, 'report'])->name('service.report')->middleware([isAuthEmployee::class]);
Route::post('/service/add',[ServiceController::class, 'addReport'])->name('service.add')->middleware([isAuthEmployee::class]);

#History Routes
Route::get('/service/history', [ServiceController::class, 'history'])->name('service.history');
    
#Service Report Print Routes
Route::get('/service/print', function () {
    return view('service.print');
})->name('service.print');

Route::get('/service/batch-print', function () {
    return view('service.batch-print');
})->name('service.batch-print');

#Client Routes
Route::get('/client/register', [AuthController::class, 'client'])->name('client.register');
Route::post('/client/register/add',[ClientController::class, 'addClient'])->name('client.add');

Route::get("/client",function(){
    return view('clientauth.login');
});

Route::get('/client/login', function (){
    return view('clientauth.login');
})->name('clientauth.login');

Route::get('client/dashboard', function(){
    return view('clientauth.dashboard');
});
Route::get('clients/machines', function(){
    return view('clients.machine');
})->name('clients.machines');

Route::get('client/service-history', function(){
    return view('clients.history');
})->name('client.service.history');

Route::get('clients/batch', function(){
    return view('clients.batch');
})->name('clients.batch');

Route::get('clients/print', function(){
    return view('clients.print');
})->name('clients.print');