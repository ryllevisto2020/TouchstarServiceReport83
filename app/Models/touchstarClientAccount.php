<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class touchstarClientAccount extends Authenticatable
{
    use HasFactory, Notifiable;
    //
    public $table = "touchstarclientaccounts";
    public $timestamps = false;
    public $fillable = [
        "client_id",
        "client_email",
        "password",
        "client_login_status"
    ];
    public $hidden = [
        "password"
    ];
    public $primaryKey = "client_account_id";
}
