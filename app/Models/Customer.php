<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory;
    use HasApiTokens,Notifiable;
    use SoftDeletes;
    public $timestamps = true;
    protected $table = "customer";
    protected $fillable = [
        "id","email","name","phone_no","gender",
        "profile_picture","dob","password","status",
        "created_by","updated_by"
    ];
}
