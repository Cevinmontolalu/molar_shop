<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProfile extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;
    protected $table = "shop_profile";
    protected $fillable = [
        'id','name','email','phone_no',
        'longitude','latitude','address',
        'created_by','updated_by'
    ];
}
