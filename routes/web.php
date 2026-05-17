<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MachineController;

use App\Http\Controllers\ServiceController;
use App\Http\Middleware\isAuthClient;
use App\Http\Middleware\isAuthEmployee;
use App\Http\Middleware\isLogin;
use App\Http\Middleware\isLoginClient;
use App\Models\Machine;
use App\Models\ServiceReport;
use App\Models\touchstarClient;
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
Route::get('/service/print/', function () {
    $service_records = ServiceReport::all();
    $machines = Machine::all();
    return view('service.print',compact("service_records","machines"));
})->name('service.print');

Route::get('/service/batch-print', function () {
    return view('service.batch-print');
})->name('service.batch-print');

#Client Routes
Route::get('/client/register', [AuthController::class, 'client'])->name('client.register');
Route::post('/client/register/add',[ClientController::class, 'addClient'])->name('client.add');
Route::post("/client/account/add",[ClientController::class,"addAccount"])->name("client.add.account");

#Client Side
Route::post("/client/login/auth",[AuthController::class,"clientAuth"])->name("client.login");
Route::post("/client/logout",function(){
    if(Auth::guard("touchstaraclientccount")->check()){
        Auth::guard('touchstaraclientccount')->logout();
        return redirect()->route('clientauth.login');
    }
})->name("client.logout");

Route::get("/client",function(){
    return view('clientauth.login');
})->middleware([isLoginClient::class]);

Route::get('/client/login', function (){
    return view('clientauth.login');
})->name('clientauth.login')->middleware([isLoginClient::class]);

Route::get('/client/dashboard', function(){
    $client_detail = touchstarClient::where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)->first();
    return view('clientauth.dashboard',compact("client_detail"));
})->name('client.dashboard')->middleware([isAuthClient::class]);

Route::get('clients/machines', function(Request $request){
        $query = Machine::query();


        // ✅ Status filter
        if ($request->has('status') && $request->status && $request->status !== 'All Statuses') {
            $query->where('status', $request->status);
        }

        // ✅ Location filter
        if ($request->has('location') && $request->location && $request->location !== 'All Locations') {
            $query->where('client_location', $request->location);
        }

        // ✅ Serial Number search (NEW)
        if ($request->has('search') && $request->search) {
            $query->where('serial_number', 'like', '%' . $request->search . '%');
        }

        // ✅ PMS Due filter
        if ($request->has('pms_due') && $request->pms_due && $request->pms_due !== 'Any Time') {
            $now = now();

            switch ($request->pms_due) {
                case 'Next 7 Days':
                    $query->whereBetween('next_service_date', [$now, $now->copy()->addDays(7)]);
                    break;

                case 'Next 30 Days':
                    $query->whereBetween('next_service_date', [$now, $now->copy()->addDays(30)]);
                    break;

                case 'Overdue':
                    $query->whereNotNull('next_service_date') // ✅ prevent null errors
                        ->where('next_service_date', '<', $now);
                    break;
            }
        }

        // ✅ Paginate
        $machines = $query->where('client_id',Auth::guard("touchstaraclientccount")->user()->client_id)->orderBy('created_at', 'desc')->paginate(50);

        // ✅ Get distinct locations for dropdown
        $locations = Machine::distinct()
            ->whereNotNull('client_location')
            ->pluck('client_location')
            ->filter()
            ->sort()
            ->values();

        // ✅ Get distinct serial numbers for search autocomplete
        $serialNumbers = Machine::distinct()
            ->whereNotNull('serial_number')
            ->pluck('serial_number')
            ->filter()
            ->sort()
            ->values();
        
        $operational = Machine::where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)
        ->where('status','Operational')->count();

        $maintenance = Machine::where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)
        ->where('status','Maintenance')->count();

        $standby = Machine::where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)
        ->where('status','Standby')->count();

        $notOperational = Machine::where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)
        ->where('status','Not Operational')->count();

        $now = now();
        $pms_overdue = Machine::whereNotNull('next_service_date')
        ->where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)
        ->where('next_service_date', '<', $now)->count();

        $client_detail = touchstarClient::where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)->first();
    return view('clients.machine',compact("machines",'locations', 'serialNumbers',
    "client_detail","operational","maintenance","standby","notOperational","pms_overdue"));
})->name('clients.machines')->middleware([isAuthClient::class]);

Route::get("clients/machines/{id}",function(Request $req){
    return "test";
});

Route::get('client/service-history', function(){
    $client_detail = touchstarClient::where("client_id",Auth::guard("touchstaraclientccount")->user()->client_id)->first();
    return view('clients.history',compact("client_detail"));
})->name('client.service.history')->middleware([isAuthClient::class]);

Route::get('clients/batch', function(){
    return view('clients.batch');
})->name('clients.batch');

Route::get('clients/print', function(){
    return view('clients.print');
})->name('clients.print');