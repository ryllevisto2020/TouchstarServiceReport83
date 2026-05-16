<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class touchstarClientAccount extends Model
{
    //
    public $table = "touchstarclientaccount";
    public $timestamps = false;
    public $fillable = [
        "client_id",
        "client_email",
        "client_password",
        "client_login_status"
    ];
    public $hidden = [
        "client_password"
    ];
    public $primaryKey = "client_account_id";
}
