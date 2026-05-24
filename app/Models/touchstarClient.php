<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class touchstarClient extends Model
{
    //
    public $table = "touchstarclient";
    public $timestamps = false;
    public $fillable = [
        "client_name",
        "client_address",
        "client_pathologist",
        "client_headMedtech",
        "client_contactPerson",
        "client_contactPhone",
        "client_email",
        "client_status",
        "client_profilepic",
        "client_account"
    ];
    public $primaryKey = "client_id";
}
