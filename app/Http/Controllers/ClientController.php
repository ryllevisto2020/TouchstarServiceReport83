<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\touchstarClient;
use App\Models\touchstarClientAccount;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    //
    public function addClient(Request $req){
        $profilePic = null;

        if($req->file("client_profilepic") != null){
            $profilePic = $req->file("client_profilepic")->store("ClientProfilePic");
        }

        $collection = collect($req);
        $data = $collection->except(["client_profilepic"]);

        $data->put("client_profilepic",$profilePic);

        touchstarClient::create($data->all())->save();

        return Response()->json(["status"=> "success"]);
    }
    public function addAccount(Request $req){
        touchstarClientAccount::create([
            "client_id" => $req->client_id,
            "client_email" => $req->client_email,
            "client_password" => Hash::make($req->client_password),
        ])->save();

        touchstarClient::find($req->client_id)->update([
            "client_account"=>"TRUE"
        ]);
        return Response()->json(["status"=> "success"]);
    }
}
