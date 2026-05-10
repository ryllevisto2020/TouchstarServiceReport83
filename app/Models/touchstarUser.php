<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class touchstarUser extends Authenticatable
{
    use HasFactory, Notifiable;
    //
    public $table = "touchstaraccount";
    public $timestamps = false;
    public $fillable = ['emp_id','touch_acc_username','touch_acc_email', 'password','touch_acc_login_status'];
    public $primaryKey = 'touch_acc_id';
    public $hidden = ['password'];
}
